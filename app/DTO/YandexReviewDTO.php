<?php

use Carbon\Carbon;

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

