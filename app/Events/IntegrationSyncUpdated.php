<?php

namespace App\Events;

use App\Models\Integration;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IntegrationSyncUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(protected Integration $integration) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('integration.' . $this->integration->id);
    }

    public function broadcastWith(): array
    {
        return [
            'status' => $this->integration->sync_status,
            'progress' => $this->integration->sync_progress,
            'error' => $this->integration->sync_error,
        ];
    }

    public function broadcastAs(): string
    {
        return 'integration.updated';
    }
}
