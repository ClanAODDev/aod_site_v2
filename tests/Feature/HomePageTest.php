<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

describe('Home Page', function () {
    beforeEach(function () {
        Cache::flush();
    });

    it('loads successfully', function () {
        // Mock the Discord API response
        $discordResponse = json_decode(
            file_get_contents(storage_path('testing/discord.json')),
            true
        );

        Http::fake([
            '*/api/v1/discord-count' => Http::response($discordResponse, 200),
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('pages.home');
        $response->assertViewHas(['discord', 'isChristmas']);
    });

    it('shows Christmas theme during Christmas season', function () {
        // Mock current date to be during Christmas season (December 1 - January 15)
        $this->travelTo(now()->setMonth(12)->setDay(15));

        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewHas('isChristmas', true);
    });

    it('does not show Christmas theme outside Christmas season', function () {
        // Mock current date to be outside Christmas season
        $this->travelTo(now()->setMonth(6)->setDay(15));

        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewHas('isChristmas', false);
    });

    it('handles Discord API failure gracefully', function () {
        Http::fake([
            '*/api/v1/discord-count' => Http::response([], 500),
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('pages.home');
    });

    it('caches Discord data correctly', function () {
        $discordData = ['data' => ['count' => 150]];

        Http::fake([
            '*/api/v1/discord-count' => Http::response($discordData, 200),
        ]);

        // First request should hit the API
        $this->get(route('home'));
        expect(Cache::has('aod_discord'))->toBeTrue();

        // Second request should use cache
        Http::fake(); // Clear all fakes to ensure no API calls
        $response = $this->get(route('home'));
        $response->assertOk();
    });

    it('uses dummy data in local environment', function () {
        app()->detectEnvironment(fn () => 'local');

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('pages.home');
        $response->assertViewHas('discord');
    });

    it('contains video modal elements', function () {
        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();

        // Check that video modal elements are present
        $response->assertSee('intro-video', false); // Check for class name
        $response->assertSee('video-iframe', false); // Check for iframe ID
        $response->assertSee('close-video', false); // Check for close button class
        $response->assertSee('play-button', false); // Check for play button class

        // Check that YouTube iframe is properly configured
        $response->assertSee('enablejsapi=1', false); // Check for YouTube API enablement
    });
});
