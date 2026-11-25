<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia;

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
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('next/home')
                ->has('discord'));
    });

    it('handles Discord API failure gracefully', function () {
        $this->fakeHttp([
            '*/api/v1/discord-count' => Http::response([], 500),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('next/home')
                ->where('discord', null));
    });

    it('caches Discord data correctly', function () {
        $discordData = ['data' => ['count' => 150]];

        $this->fakeHttp([
            '*/api/v1/discord-count' => Http::response($discordData, 200),
        ]);

        $this->get(route('home'));
        expect(Cache::get('aod_discord'))->toBe($discordData['data']);

        $this->fakeHttp([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 999]], 200),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('discord', $discordData['data']));
    });

    it('uses dummy data in local environment', function () {
        app()->detectEnvironment(fn () => 'local');

        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('next/home')
                ->has('discord'));
    });

    it('passes the props the hero video modal needs', function () {
        Http::fake([
            '*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('heroVideoId', config('aod.hero_video_id'))
                ->where('introVideoId', config('aod.intro_video_id')));
    });
});
