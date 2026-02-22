<?php

namespace app\Services;

use App\Models\Integration;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use ReviewRepository;

class YandexSyncService
{
    protected YandexClientService $client;
    protected ReviewRepository $repository;

    public function __construct(
        YandexClientService $client,
        ReviewRepository $repository
    ) {
        $this->client = $client;
        $this->repository = $repository;
    }

    /**
     * @throws ValidationException
     */
    public function sync(Integration $integration, callable $progressCallback): void
    {
        $page = 1;
        $totalProcessed = 0;

        do {
            $response = $this->client->getReviews($integration->company_id, $page);

            foreach ($response['data'] as $item) {
                $dto = new \YandexReviewDTO(
                    externalId: $item['id'],
                    author: $item['author']['name'],
                    rating: $item['rating'],
                    text: $item['text'] ?? null,
                    publishedAt: Carbon::parse($item['date']),
                    raw: $item
                );
                $this->repository->upsert($integration, $dto);
                $totalProcessed++;
            }

            $progress = min(95, $totalProcessed % 100);
            $progressCallback($progress);

            $hasNext = count($response['data']) === ReviewRepository::PER_PAGE;
//            $hasNext = $response['meta']['current_page'] <
//                ceil($response['meta']['total'] / $response['meta']['per_page']);

            $page++;

        } while ($hasNext);

        $company = $this->client->getCompany($integration->company_id);

        if (!$company) {
            throw ValidationException::withMessages([
                'url' => 'Компания не найдена'
            ]);
        }

        $integration->update([
            'rating' => $company['rating'],
            'reviews_count' => $company['review_count'],
            'last_synced_at' => now(),
        ]);
    }
}
