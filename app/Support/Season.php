<?php

declare(strict_types=1);

namespace App\Support;

use Carbon\CarbonImmutable;

class Season
{
    public function current(): ?array
    {
        $seasons = config('aod.seasons', []);

        if (app()->environment('local') && is_string(request()->query('season'))) {
            return collect($seasons)->firstWhere('id', request()->query('season'));
        }

        $today = CarbonImmutable::now();

        foreach ($seasons as $season) {
            if (self::includes($season['start'], $season['end'], $today)) {
                return $season;
            }
        }

        return null;
    }

    public static function includes(string $start, string $end, CarbonImmutable $day): bool
    {
        $mmdd = $day->format('m-d');

        return $start <= $end
            ? $mmdd >= $start && $mmdd <= $end
            : $mmdd >= $start || $mmdd <= $end;
    }
}
