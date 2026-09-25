<?php

declare(strict_types=1);

namespace App\Support;

use Closure;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TrackerCache
{
    public static function remember(string $key, Closure $fetch): mixed
    {
        return Cache::flexible(
            $key,
            [config('app.cache_length'), config('app.cache_stale_length')],
            function () use ($key, $fetch) {
                try {
                    return $fetch();
                } catch (HttpClientException $e) {
                    Log::warning("Tracker request for [{$key}] failed: {$e->getMessage()}");

                    return Cache::get($key);
                }
            }
        );
    }
}
