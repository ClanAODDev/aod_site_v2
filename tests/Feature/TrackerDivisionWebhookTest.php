<?php

use App\Http\Controllers\TrackerDivisionWebhookController;
use App\Support\OnSiteDivisions;
use App\Support\TrackerDivisions;
use Illuminate\Support\Facades\Cache;

describe('Tracker division webhook', function () {
    beforeEach(function () {
        config(['services.aod.tracker_webhook_secret' => 'shared-secret']);

        Cache::put('aod_division_details_battlefield', ['stale' => true]);
        Cache::put('aod_division_details_destiny', ['stale' => true]);
        Cache::put(TrackerDivisions::CACHE_KEY, ['stale' => true]);
        Cache::put(OnSiteDivisions::CACHE_KEY, ['stale' => true]);
    });

    $send = function (array $payload, ?string $secret = 'shared-secret') {
        $body = json_encode($payload);
        $headers = ['CONTENT_TYPE' => 'application/json'];

        if ($secret !== null) {
            $headers['HTTP_' . str_replace('-', '_', strtoupper(TrackerDivisionWebhookController::SIGNATURE_HEADER))] = 'sha256=' . hash_hmac('sha256', $body, $secret);
        }

        return $this->call('POST', '/webhooks/tracker/divisions', [], [], [], $headers, $body);
    };

    it('clears the division and the division lists for a signed request', function () use ($send) {
        $send->call($this, ['slug' => 'battlefield'])->assertNoContent();

        expect(Cache::has('aod_division_details_battlefield'))->toBeFalse()
            ->and(Cache::has(TrackerDivisions::CACHE_KEY))->toBeFalse()
            ->and(Cache::has(OnSiteDivisions::CACHE_KEY))->toBeFalse()
            ->and(Cache::has('aod_division_details_destiny'))->toBeTrue();
    });

    it('rejects a bad or missing signature and leaves the cache alone', function (?string $secret) use ($send) {
        $send->call($this, ['slug' => 'battlefield'], $secret)->assertForbidden();

        expect(Cache::has('aod_division_details_battlefield'))->toBeTrue()
            ->and(Cache::has(TrackerDivisions::CACHE_KEY))->toBeTrue();
    })->with([
        'wrong secret' => ['not-the-secret'],
        'unsigned' => [null],
    ]);

    it('is closed when no secret is configured', function () use ($send) {
        config(['services.aod.tracker_webhook_secret' => null]);

        $send->call($this, ['slug' => 'battlefield'], '')->assertNotFound();

        expect(Cache::has('aod_division_details_battlefield'))->toBeTrue();
    });

    it('rejects a malformed slug', function () use ($send) {
        $send->call($this, ['slug' => '../../etc'])->assertStatus(422);
    });
});
