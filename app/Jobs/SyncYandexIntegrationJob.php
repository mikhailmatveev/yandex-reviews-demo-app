<?php

use App\Events\IntegrationSyncUpdated;
use App\Models\Integration;
use app\Services\YandexSyncService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncYandexIntegrationJob implements ShouldQueue
{
    use Dispatchable;

    public function __construct(protected Integration $integration) {}

    public function handle(YandexSyncService $service): void
    {
        $this->integration->update([
            'sync_status' => 'syncing',
            'sync_progress' => 0,
            'sync_error' => null
        ]);

        event(new IntegrationSyncUpdated($this->integration));

        try {
            $service->sync(
                $this->integration,
                function ($progress) {
                    $this->integration->update([
                        'sync_progress' => $progress
                    ]);

                    event(new IntegrationSyncUpdated($this->integration));
                }
            );

            $this->integration->update([
                'sync_status' => 'success',
                'sync_progress' => 100
            ]);

        } catch (\Throwable $e) {

            $this->integration->update([
                'sync_status' => 'error',
                'sync_error' => $e->getMessage()
            ]);
        }

        event(new IntegrationSyncUpdated($this->integration));
    }
}

