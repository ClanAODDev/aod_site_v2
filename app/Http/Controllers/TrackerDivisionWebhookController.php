<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\OnSiteDivisions;
use App\Support\TrackerDivisions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class TrackerDivisionWebhookController extends Controller
{
    public const SIGNATURE_HEADER = 'X-Tracker-Signature';

    public function __invoke(Request $request): Response
    {
        $secret = (string) config('services.aod.tracker_webhook_secret');

        abort_if($secret === '', 404);

        $expected = 'sha256=' . hash_hmac('sha256', $request->getContent(), $secret);

        abort_unless(hash_equals($expected, (string) $request->header(self::SIGNATURE_HEADER)), 403);

        $slug = $request->json('slug');

        abort_unless(is_string($slug) && preg_match('/^[a-z0-9-]{1,64}$/', $slug), 422);

        Cache::forget('aod_division_details_' . $slug);
        Cache::forget(TrackerDivisions::CACHE_KEY);
        Cache::forget(OnSiteDivisions::CACHE_KEY);

        return response()->noContent();
    }
}
