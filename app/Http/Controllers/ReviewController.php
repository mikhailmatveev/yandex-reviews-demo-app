<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Integration;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use ReviewRepository;

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
