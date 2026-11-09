<?php

declare(strict_types=1);

namespace App\Support;

use Facades\App\Repositories\AOD\DivisionRepository;

class TrackerDivisions
{
    public const CACHE_KEY = 'aod_all_divisions';

    public static function all(): array
    {
        return TrackerCache::remember(
            self::CACHE_KEY,
            fn () => array_values(DivisionRepository::all()->throw()->json('data') ?? [])
        ) ?? [];
    }

    public static function hasSlug(string $slug): ?bool
    {
        $divisions = self::all();

        if ($divisions === []) {
            return null;
        }

        foreach ($divisions as $division) {
            if (strcasecmp((string) ($division['slug'] ?? ''), $slug) === 0) {
                return true;
            }
        }

        return false;
    }
}
