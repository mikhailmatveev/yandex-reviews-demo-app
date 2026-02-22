<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use App\Repositories\ReviewRepository;
use App\Resources\ReviewResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewRepository $repository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/reviews",
     *     summary="Получить список отзывов",
     *     tags={"API"},
     *
     *     security={{"sanctumAuth":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Список отзывов",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Review")
     *         )
     *     )
     * )
     */
    public function show(): AnonymousResourceCollection
    {
        $integration = Integration::first();
        $reviews = $this->repository->paginate($integration);
        return ReviewResource::collection($reviews);
    }
}
