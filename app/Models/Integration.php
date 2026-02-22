<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Integration",
 *     title="Integration",
 *     description="Интеграция с внешним провайдером (например, Yandex)",
 *     type="object",
 *     required={"id","provider","url","company_id"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *
 *     @OA\Property(
 *         property="provider",
 *         type="string",
 *         example="yandex",
 *         description="Название провайдера интеграции"
 *     ),
 *
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         example="https://yandex.ru/maps/org/example",
 *         description="URL компании во внешнем сервисе"
 *     ),
 *
 *     @OA\Property(
 *         property="company_id",
 *         type="integer",
 *         example=10,
 *         description="ID компании в системе"
 *     ),
 *
 *     @OA\Property(
 *         property="rating",
 *         type="number",
 *         format="float",
 *         nullable=true,
 *         example=4.7,
 *         description="Средний рейтинг компании"
 *     ),
 *
 *     @OA\Property(
 *         property="reviews_count",
 *         type="integer",
 *         nullable=true,
 *         example=125,
 *         description="Количество отзывов"
 *     ),
 *
 *     @OA\Property(
 *         property="sync_status",
 *         type="string",
 *         nullable=true,
 *         example="completed",
 *         description="Статус синхронизации (pending, in_progress, completed, failed)"
 *     ),
 *
 *     @OA\Property(
 *         property="sync_progress",
 *         type="integer",
 *         nullable=true,
 *         example=75,
 *         description="Прогресс синхронизации в процентах"
 *     ),
 *
 *     @OA\Property(
 *         property="sync_error",
 *         type="string",
 *         nullable=true,
 *         example="Invalid API key",
 *         description="Описание ошибки синхронизации"
 *     ),
 *
 *     @OA\Property(
 *         property="last_synced_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="Дата последней синхронизации"
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
class Integration extends Model
{
    protected $fillable = [
        'provider',
        'url',
        'company_id',
        'rating',
        'reviews_count',
        'sync_status',
        'sync_progress',
        'sync_error',
        'last_synced_at',
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
