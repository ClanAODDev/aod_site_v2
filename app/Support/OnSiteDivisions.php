<?php

declare(strict_types=1);

namespace App\Support;

use Facades\App\Repositories\AOD\DivisionRepository;

class OnSiteDivisions
{
    public const CACHE_KEY = 'aod_divisions';

    public static function get(): array
    {
        return cache()->remember(
            self::CACHE_KEY,
            config('app.cache_length'),
            fn () => self::fetch()
        );
    }

    private static function fetch(): array
    {
        if (! $divisions = DivisionRepository::all()->json('data')) {
            return [];
        }

        return array_filter($divisions, fn ($division) => isset($division['show_on_site']) && $division['show_on_site'] !== false);
    }
}
