<?php

namespace App\Http\Controllers;

use App\Helpers\YandexUrlParser;
use App\Http\Requests\StoreIntegrationRequest;
use App\Jobs\SyncYandexIntegrationJob;
use App\Models\Integration;
use Illuminate\Http\JsonResponse;

class IntegrationController extends Controller
{
    public function show()
    {
        return Integration::first();
    }

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

