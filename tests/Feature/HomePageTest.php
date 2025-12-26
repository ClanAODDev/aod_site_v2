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

describe('Twitch and Highlighted Event Priority', function () {
    beforeEach(function () {
        Cache::flush();

        $divisionsData = json_decode(
            file_get_contents(storage_path('testing/divisions.json')),
            true
        );

        $this->divisionsResponse = $divisionsData;
    });

    it('shows live twitch stream instead of highlighted event when stream is live', function () {
        $this->travelTo(now()->setMonth(12)->setDay(15));

        config([
            'services.twitch.client_id' => 'test_client_id',
            'services.twitch.client_secret' => 'test_client_secret',
            'services.twitch.channel' => 'clanaodstream',
            'services.twitch.api_base' => 'https://api.twitch.tv/helix',
            'services.twitch.oauth_url' => 'https://id.twitch.tv/oauth2/token',
            'aod.highlighted_events' => [
                [
                    'id' => 'test-event',
                    'enabled' => true,
                    'start_date' => '12-01',
                    'end_date' => '01-15',
                    'theme' => 'holiday',
                    'badge' => ['icon' => 'fas fa-star', 'text' => 'Test Event'],
                    'title' => 'Test Event Title',
                    'description' => 'Test description',
                ],
            ],
        ]);

        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
            '*/api/v1/divisions' => Http::response($this->divisionsResponse, 200),
            'https://id.twitch.tv/oauth2/token' => Http::response(['access_token' => 'test_token'], 200),
            'https://api.twitch.tv/helix/users*' => Http::response(['data' => [['id' => '123456789']]], 200),
            'https://api.twitch.tv/helix/streams*' => Http::response(['data' => [
                [
                    'id' => '41234567890',
                    'user_id' => '123456789',
                    'user_login' => 'clanaodstream',
                    'user_name' => 'ClanAODStream',
                    'game_name' => 'Call of Duty: Warzone',
                    'title' => 'AOD Community Night',
                    'viewer_count' => 47,
                ],
            ]], 200),
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewHas('showTwitchLive', true);
        $response->assertViewHas('showHighlightedEvent', false);
        $response->assertViewHas('showVods', false);
    });

    it('shows highlighted event when stream is offline and event is active', function () {
        $this->travelTo(now()->setMonth(12)->setDay(15));

        config([
            'services.twitch.client_id' => 'test_client_id',
            'services.twitch.client_secret' => 'test_client_secret',
            'services.twitch.channel' => 'clanaodstream',
            'services.twitch.api_base' => 'https://api.twitch.tv/helix',
            'services.twitch.oauth_url' => 'https://id.twitch.tv/oauth2/token',
            'aod.highlighted_events' => [
                [
                    'id' => 'test-event',
                    'enabled' => true,
                    'start_date' => '12-01',
                    'end_date' => '01-15',
                    'theme' => 'holiday',
                    'badge' => ['icon' => 'fas fa-star', 'text' => 'Test Event'],
                    'title' => 'Test Event Title',
                    'description' => 'Test description',
                ],
            ],
        ]);

        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
            '*/api/v1/divisions' => Http::response($this->divisionsResponse, 200),
            'https://id.twitch.tv/oauth2/token' => Http::response(['access_token' => 'test_token'], 200),
            'https://api.twitch.tv/helix/users*' => Http::response(['data' => [['id' => '123456789']]], 200),
            'https://api.twitch.tv/helix/streams*' => Http::response(['data' => []], 200),
            'https://api.twitch.tv/helix/videos*' => Http::response(['data' => [
                [
                    'id' => '123',
                    'title' => 'VOD 1',
                    'thumbnail_url' => 'https://example.com/thumb-%{width}x%{height}.jpg',
                    'url' => 'https://www.twitch.tv/videos/123',
                    'duration' => '1h30m',
                    'view_count' => 100,
                ],
            ]], 200),
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewHas('showTwitchLive', false);
        $response->assertViewHas('showHighlightedEvent', true);
        $response->assertViewHas('showVods', false);
    });

    it('shows VODs when stream is offline and no highlighted event is active', function () {
        $this->travelTo(now()->setMonth(6)->setDay(15));

        config([
            'services.twitch.client_id' => 'test_client_id',
            'services.twitch.client_secret' => 'test_client_secret',
            'services.twitch.channel' => 'clanaodstream',
            'services.twitch.api_base' => 'https://api.twitch.tv/helix',
            'services.twitch.oauth_url' => 'https://id.twitch.tv/oauth2/token',
            'aod.highlighted_events' => [
                [
                    'id' => 'test-event',
                    'enabled' => true,
                    'start_date' => '12-01',
                    'end_date' => '01-15',
                    'theme' => 'holiday',
                    'badge' => ['icon' => 'fas fa-star', 'text' => 'Test Event'],
                    'title' => 'Test Event Title',
                    'description' => 'Test description',
                ],
            ],
        ]);

        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
            '*/api/v1/divisions' => Http::response($this->divisionsResponse, 200),
            'https://id.twitch.tv/oauth2/token' => Http::response(['access_token' => 'test_token'], 200),
            'https://api.twitch.tv/helix/users*' => Http::response(['data' => [['id' => '123456789']]], 200),
            'https://api.twitch.tv/helix/streams*' => Http::response(['data' => []], 200),
            'https://api.twitch.tv/helix/videos*' => Http::response(['data' => [
                [
                    'id' => '123',
                    'title' => 'VOD 1',
                    'thumbnail_url' => 'https://example.com/thumb-%{width}x%{height}.jpg',
                    'url' => 'https://www.twitch.tv/videos/123',
                    'duration' => '1h30m',
                    'view_count' => 100,
                ],
            ]], 200),
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewHas('showTwitchLive', false);
        $response->assertViewHas('showHighlightedEvent', false);
        $response->assertViewHas('showVods', true);
    });
});
