<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Repositories\ReviewRepository;

class YandexClientService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.yandex.key');
    }

    public function getCompany(string $companyId): array
    {
        return Http::withToken($this->apiKey)
            ->get("https://api.business.yandex.ru/v1/company/$companyId")
            ->json();
    }

    public function getReviews(string $companyId, int $page = 1): array
    {
        return Http::withToken($this->apiKey)
            ->get("https://api.business.yandex.ru/v1/company/$companyId/reviews", [
                'page' => $page,
                'limit' => ReviewRepository::PER_PAGE,
                'sort' => 'date'
            ])->json();
    }
}
