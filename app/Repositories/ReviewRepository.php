<?php

namespace App\Repositories;

use App\DTO\YandexReviewDTO;
use App\Models\Integration;
use App\Models\Review;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewRepository
{
    const int PER_PAGE = 20;

    public function upsert(Integration $integration, YandexReviewDTO $dto): void
    {
        Review::updateOrCreate(
            [
                'integration_id' => $integration->id,
                'external_id' => $dto->externalId
            ], [
                'author_name' => $dto->author,
                'rating' => $dto->rating,
                'text' => $dto->text,
                'published_at' => $dto->publishedAt,
                'raw' => $dto->raw
            ]
        );
    }

    public function paginate(Integration $integration, int $perPage = self::PER_PAGE): LengthAwarePaginator
    {
        return $integration
            ->reviews()
            ->orderByDesc('published_at')
            ->paginate($perPage);
    }
}

