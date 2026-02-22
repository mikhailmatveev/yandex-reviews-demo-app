<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Review",
 *     title="Review",
 *     description="Отзыв, связанный с интеграцией",
 *     type="object",
 *     required={"id","integration_id","external_id","author_name","rating","text"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *
 *     @OA\Property(
 *         property="integration_id",
 *         type="integer",
 *         example=1,
 *         description="ID интеграции, к которой относится отзыв"
 *     ),
 *
 *     @OA\Property(
 *         property="external_id",
 *         type="string",
 *         example="1234567890",
 *         description="ID отзыва во внешнем сервисе (например, Яндекс)"
 *     ),
 *
 *     @OA\Property(
 *         property="author_name",
 *         type="string",
 *         example="Иван Иванов",
 *         description="Имя автора отзыва"
 *     ),
 *
 *     @OA\Property(
 *         property="rating",
 *         type="integer",
 *         minimum=1,
 *         maximum=5,
 *         example=5,
 *         description="Оценка отзыва"
 *     ),
 *
 *     @OA\Property(
 *         property="text",
 *         type="string",
 *         example="Отличный сервис, всё понравилось!",
 *         description="Текст отзыва"
 *     ),
 *
 *     @OA\Property(
 *         property="published_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="Дата публикации отзыва во внешнем сервисе"
 *     ),
 *
 *     @OA\Property(
 *         property="raw",
 *         type="object",
 *         nullable=true,
 *         description="Исходные данные отзыва в виде JSON/массива",
 *         example={"foo":"bar","baz":123}
 *     ),
 *
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time"
 *     ),
 *
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time"
 *     )
 * )
 */
class Review extends Model
{
    protected $fillable = [
        'integration_id',
        'external_id',
        'author_name',
        'rating',
        'text',
        'published_at',
        'raw',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'raw' => 'array',
    ];

    public function integration(): BelongsTo
    {
        return $this->belongsTo(Integration::class);
    }
}
