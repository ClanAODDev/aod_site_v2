<?php

use App\Repositories\AOD\Repository;
use App\Repositories\AOD\SocialRepository;
use Illuminate\Support\Facades\Http;

describe('External API Integration', function () {
    it('requires tracker access token', function () {
        config()->set('services.aod.access_token', null);

        expect(fn () => new Repository)
            ->toThrow(Exception::class, 'Tracker access token missing');
    });

    it('handles missing access token gracefully on home page', function () {
        config()->set('services.aod.access_token', null);

        $response = $this->get(route('home'));

        $response->assertStatus(500);
        $response->assertSee('Tracker access token missing');
    });

    it('works with valid access token', function () {
        config()->set('services.aod.access_token', 'valid-token');
        config()->set('services.aod.tracker_url', 'https://api.example.com');

        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
            '*/api/v1/divisions' => Http::response(['data' => []], 200),
        ]);

        $response = $this->get(route('home'));
        $response->assertOk();
    });

    it('handles API timeouts gracefully', function () {
        config()->set('services.aod.access_token', 'valid-token');
        config()->set('services.aod.tracker_url', 'https://api.example.com');

        Http::fake([
            '*/api/v1/discord-count' => Http::response([], 408), // Timeout
            '*/api/v1/divisions' => Http::response(['data' => []], 200),
        ]);

        $response = $this->get(route('home'));
        $response->assertOk(); // Should still load page
    });

    it('handles API server errors gracefully', function () {
        config()->set('services.aod.access_token', 'valid-token');
        config()->set('services.aod.tracker_url', 'https://api.example.com');

        Http::fake([
            '*/api/v1/discord-count' => Http::response([], 500),
            '*/api/v1/divisions' => Http::response(['data' => []], 200),
        ]);

        $response = $this->get(route('home'));
        $response->assertOk(); // Should still load page
    });

    it('validates API response structure', function () {
        config()->set('services.aod.access_token', 'valid-token');
        config()->set('services.aod.tracker_url', 'https://api.example.com');

        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 150]], 200),
        ]);

        $repository = new SocialRepository;
        $response = $repository->getDiscord();

        expect($response->json('data.count'))->toBe(150);
    });

    it('handles malformed API responses', function () {
        config()->set('services.aod.access_token', 'valid-token');
        config()->set('services.aod.tracker_url', 'https://api.example.com');

        Http::fake([
            '*/api/v1/discord-count' => Http::response('invalid json', 200),
            '*/api/v1/divisions' => Http::response(['data' => []], 200),
        ]);

        $response = $this->get(route('home'));
        $response->assertOk(); // Should still load page despite bad API response
    });
});
