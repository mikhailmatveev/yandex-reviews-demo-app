<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Преобразует модель в массив для JSON
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'author_name' => $this->author_name,
            'rating' => $this->rating,
            'text' => $this->text,
            'published_at' => $this->published_at->toDateTimeString(),
        ];
    }
}
