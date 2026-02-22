<?php

namespace App\DTO;

use Carbon\Carbon;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="YandexReview",
 *     title="Yandex Review",
 *     description="DTO для корректного маппинга JSON-структуры отзыва в таблицу",
 *     type="object",
 *     required={"id","author","rating","text","created_at"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         example="123456789"
 *     ),
 *     @OA\Property(
 *         property="author",
 *         type="string",
 *         example="Иван Иванов"
 *     ),
 *     @OA\Property(
 *         property="rating",
 *         type="integer",
 *         example=5
 *     ),
 *     @OA\Property(
 *         property="text",
 *         type="string",
 *         example="Отличный сервис!"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-01-15T12:00:00Z"
 *     )
 * )
 */
class YandexReviewDTO
{
    public function __construct(
        public string $externalId,
        public string $author,
        public int $rating,
        public ?string $text,
        public Carbon $publishedAt,
        public array $raw
    ) {}
}

