<?php

namespace App\Helpers;

class YandexUrlParser
{
    public static function extractCompanyId(string $url): ?string
    {
        preg_match('/org\/.*?\/(\d+)/', $url, $matches);
        return $matches[1] ?? null;
    }
}
