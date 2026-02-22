<?php

namespace App\Http\Controllers;

use App\Helpers\YandexUrlParser;
use App\Http\Requests\StoreIntegrationRequest;
use App\Jobs\SyncYandexIntegrationJob;
use App\Models\Integration;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class IntegrationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/integration",
     *     summary="Получить текущую интеграцию",
     *     description="Возвращает информацию о текущей интеграции Яндекс",
     *     tags={"API"},
     *
     *     security={{"sanctumAuth":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Интеграция найдена",
     *         @OA\JsonContent(ref="#/components/schemas/Integration")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Интеграция не найдена"
     *     )
     * )
     */
    public function show()
    {
        return Integration::first();
    }

    /**
     * @OA\Post(
     *     path="/api/integration",
     *     summary="Создать интеграцию",
     *     description="Создаёт новую интеграцию с внешним провайдером",
     *     tags={"API"},
     *
     *     security={{"sanctumAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"provider","url","company_id"},
     *             @OA\Property(property="provider", type="string", example="yandex"),
     *             @OA\Property(property="url", type="string", example="https://yandex.ru/maps/org/example"),
     *             @OA\Property(property="company_id", type="integer", example=10)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Интеграция успешно создана",
     *         @OA\JsonContent(ref="#/components/schemas/Integration")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The url field is required."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 additionalProperties=@OA\Property(
     *                     type="array",
     *                     @OA\Items(type="string")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreIntegrationRequest $request): JsonResponse
    {
        $companyId = YandexUrlParser::extractCompanyId($request->url);

        if (!$companyId) {
            return response()->json([
                'message' => 'Неверная ссылка на Яндекс организацию'
            ], 422);
        }

        $integration = Integration::updateOrCreate(
            ['provider' => 'yandex'],
            [
                'company_id' => $companyId,
                'url' => $request->url,
            ]
        );

        SyncYandexIntegrationJob::dispatch($integration);

        return response()->json([
            'message' => 'Интеграция сохранена. Начата синхронизация.',
            'integration' => $integration
        ]);
    }
}

