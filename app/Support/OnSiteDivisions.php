<?php

declare(strict_types=1);

namespace App\Support;

use Facades\App\Repositories\AOD\DivisionRepository;
use Illuminate\Support\Str;

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

    /**
     * The API returns divisions keyed by id rather than as a sequential list, and
     * array_filter() preserves those keys - re-index with array_values() so this
     * serializes as a JSON array (the Inertia `divisions` prop is typed as one),
     * not an object.
     */
    private static function fetch(): array
    {
        if (! $divisions = DivisionRepository::all()->json('data')) {
            return [];
        }

        $onSite = array_filter($divisions, fn ($division) => isset($division['show_on_site']) && $division['show_on_site'] !== false);

        return array_values(array_map(
            fn ($division) => [...$division, 'href' => route('division.show', Str::slug($division['name']))],
            $onSite
        ));
    }
}
