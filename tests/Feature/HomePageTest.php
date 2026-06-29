<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

describe('Home Page', function () {
    beforeEach(function () {
        Cache::flush();
    });

    it('loads successfully', function () {
        $discordResponse = json_decode(
            file_get_contents(storage_path('testing/discord.json')),
            true
        );

        Http::fake([
            '*/api/v1/discord-count' => Http::response($discordResponse, 200),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertViewIs('pages.home')
            ->assertViewHas(['discord', 'isChristmas']);
    });

    it('shows Christmas theme during Christmas season', function () {
        $this->travelTo(now()->setMonth(12)->setDay(15));

        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('isChristmas', true);
    });

    it('does not show Christmas theme outside Christmas season', function () {
        $this->travelTo(now()->setMonth(6)->setDay(15));

        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('isChristmas', false);
    });

    it('handles Discord API failure gracefully', function () {
        Http::fake([
            '*/api/v1/discord-count' => Http::response([], 500),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertViewIs('pages.home');
    });

    it('caches Discord data correctly', function () {
        $discordData = ['data' => ['count' => 150]];

        Http::fake([
            '*/api/v1/discord-count' => Http::response($discordData, 200),
        ]);

        $this->get(route('home'));
        expect(Cache::has('aod_discord'))->toBeTrue();

        Http::fake();
        $this->get(route('home'))->assertOk();
    });

    it('uses dummy data in local environment', function () {
        app()->detectEnvironment(fn () => 'local');

        $this->get(route('home'))
            ->assertOk()
            ->assertViewIs('pages.home')
            ->assertViewHas('discord');
    });

    it('contains video modal elements', function () {
        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('intro-video', false)
            ->assertSee('video-iframe', false)
            ->assertSee('close-video', false)
            ->assertSee('play-button', false)
            ->assertSee('enablejsapi=1', false);
    });
});

describe('Twitch and Highlighted Event Priority', function () {
    beforeEach(function () {
        Cache::flush();

        $divisionsData = json_decode(
            file_get_contents(storage_path('testing/divisions.json')),
            true
        );

        config([
            'services.twitch.client_id' => 'test_client_id',
            'services.twitch.client_secret' => 'test_client_secret',
            'services.twitch.channel' => 'clanaodstream',
            'services.twitch.api_base' => 'https://api.twitch.tv/helix',
            'services.twitch.oauth_url' => 'https://id.twitch.tv/oauth2/token',
            'aod.highlighted_events' => [[
                'id' => 'test-event',
                'enabled' => true,
                'start_date' => '12-01',
                'end_date' => '01-15',
                'theme' => 'holiday',
                'badge' => ['icon' => 'fas fa-star', 'text' => 'Test Event'],
                'title' => 'Test Event Title',
                'description' => 'Test description',
            ]],
        ]);

        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
            '*/api/v1/divisions' => Http::response($divisionsData, 200),
            'https://id.twitch.tv/oauth2/token' => Http::response(['access_token' => 'test_token'], 200),
            'https://api.twitch.tv/helix/users*' => Http::response(['data' => [['id' => '123456789']]], 200),
        ]);
    });

    it('shows live twitch stream instead of highlighted event when stream is live', function () {
        $this->travelTo(now()->setMonth(12)->setDay(15));

        Http::fake([
            'https://api.twitch.tv/helix/streams*' => Http::response(['data' => [[
                'id' => '41234567890',
                'user_id' => '123456789',
                'user_login' => 'clanaodstream',
                'user_name' => 'ClanAODStream',
                'game_name' => 'Call of Duty: Warzone',
                'title' => 'AOD Community Night',
                'viewer_count' => 47,
            ]]], 200),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('showTwitchLive', true)
            ->assertViewHas('showHighlightedEvent', false)
            ->assertViewHas('showVods', false);
    });

    it('shows highlighted event when stream is offline and event is active', function () {
        $this->travelTo(now()->setMonth(12)->setDay(15));

        Http::fake([
            'https://api.twitch.tv/helix/streams*' => Http::response(['data' => []], 200),
            'https://api.twitch.tv/helix/videos*' => Http::response(['data' => [[
                'id' => '123',
                'title' => 'VOD 1',
                'thumbnail_url' => 'https://example.com/thumb-%{width}x%{height}.jpg',
                'url' => 'https://www.twitch.tv/videos/123',
                'duration' => '1h30m',
                'view_count' => 100,
            ]]], 200),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('showTwitchLive', false)
            ->assertViewHas('showHighlightedEvent', true)
            ->assertViewHas('showVods', false);
    });

    it('shows VODs when stream is offline and no highlighted event is active', function () {
        $this->travelTo(now()->setMonth(6)->setDay(15));

        Http::fake([
            'https://api.twitch.tv/helix/streams*' => Http::response(['data' => []], 200),
            'https://api.twitch.tv/helix/videos*' => Http::response(['data' => [[
                'id' => '123',
                'title' => 'VOD 1',
                'thumbnail_url' => 'https://example.com/thumb-%{width}x%{height}.jpg',
                'url' => 'https://www.twitch.tv/videos/123',
                'duration' => '1h30m',
                'view_count' => 100,
            ]]], 200),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertViewHas('showTwitchLive', false)
            ->assertViewHas('showHighlightedEvent', false)
            ->assertViewHas('showVods', true);
    });
});
