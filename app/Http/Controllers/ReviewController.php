<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use App\Repositories\ReviewRepository;
use App\Resources\ReviewResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewRepository $repository
    ) {}

    public function show(): AnonymousResourceCollection
    {
        $integration = Integration::first();
        $reviews = $this->repository->paginate($integration);
        return ReviewResource::collection($reviews);
    }
}
