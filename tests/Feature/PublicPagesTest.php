<?php

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia;

describe('Public pages', function () {
    beforeEach(function () {
        Cache::flush();

        Http::fake([
            '*/api/v1/discord-count' => Http::response(json_decode(file_get_contents(storage_path('testing/discord.json')), true)),
            '*/api/v1/divisions' => Http::response(json_decode(file_get_contents(storage_path('testing/divisions.json')), true)),
        ]);
    });

    it('renders the home page', function () {
        $this->get('/')
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('next/home')
                ->where('foundedYear', 1999)
                ->where('currentYear', (int) now()->year)
                ->has('discord')
                ->has('twitch.vods')
                ->has('twitch.channel'));
    });

    it('passes eight store links for the merch section', function () {
        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('merch.storeUrl', config('aod.merch.store_url'))
                ->has('merch.items', 8)
                ->where('merch.items.0.href', fn (string $href) => str_starts_with($href, config('aod.merch.store_url') . '/'))
                ->where('merch.items.0.image', fn (string $image) => str_starts_with($image, config('aod.merch.image_base_url'))));
    });

    it('renders the ranks and code of conduct pages', function (string $path, string $component) {
        $this->get($path)
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component($component)
                ->where('foundedYear', 1999));
    })->with([
        'ranks' => ['/ranks', 'next/ranks'],
        'code of conduct' => ['/code-of-conduct', 'next/code-of-conduct'],
    ]);

    it('renders the fallen angels page', function () {
        Http::fake([
            '*/api/v1/fallen-members' => Http::response(json_decode(file_get_contents(storage_path('testing/fallen-members.json')), true)),
        ]);
        $this->get('/fallen-angels')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('next/fallen-angels')
                ->has('fallen', 2));
    });

    it('renders a division with its leadership but without Discord IDs', function () {
        Http::fake([
            '*/api/v1/divisions/battlefield*' => Http::response(['data' => ['division' => [
                'name' => 'Battlefield',
                'slug' => 'battlefield',
                'abbreviation' => 'bf',
                'members_count' => 233,
                'icon' => 'https://example.com/bf.png',
                'site_content' => "## About\n\nWe play Battlefield.",
                'screenshots' => [],
                'leadership' => [[
                    'name' => 'Leader',
                    'position' => 'Commanding Officer',
                    'rank' => ['label' => 'Sgt', 'color' => '#ff0000'],
                    'discord_id' => '444444444444444444',
                ]],
            ]]]),
            '*/api/v1/divisions' => Http::response(['data' => [['name' => 'Battlefield', 'slug' => 'battlefield', 'show_on_site' => true]]]),
        ]);
        $response = $this->get('/divisions/battlefield')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('next/division')
                ->where('division.name', 'Battlefield')
                ->where('division.membersCount', 233)
                ->where('division.leadership.0.rank', 'Sgt')
                ->where('division.leadership.0', fn ($leader) => ! collect($leader)->has('discord_id')));

        expect($response->getContent())->not->toContain('444444444444444444');
    });

    it('picks the hero image, then the first screenshot, as the division backdrop', function (array $extra, ?string $backdrop) {
        Http::fake([
            '*/api/v1/divisions/battlefield*' => Http::response(['data' => ['division' => [
                'name' => 'Battlefield',
                'slug' => 'battlefield',
                'abbreviation' => 'bf',
                'members_count' => 1,
                ...$extra,
            ]]]),
            '*/api/v1/divisions' => Http::response(['data' => [['name' => 'Battlefield', 'slug' => 'battlefield', 'show_on_site' => true]]]),
        ]);
        $this->get('/divisions/battlefield')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('division.backdrop', $backdrop));
    })->with([
        'hero image' => [['hero_image' => 'https://example.com/hero.jpg', 'screenshots' => [['url' => 'https://example.com/shot.jpg']]], 'https://example.com/hero.jpg'],
        'first screenshot' => [['screenshots' => [['url' => 'https://example.com/shot.jpg'], ['url' => 'https://example.com/two.jpg']]], 'https://example.com/shot.jpg'],
        'nothing' => [[], null],
    ]);

    it('passes the header image position only with a valid position on a header image', function (array $extra, ?string $position) {
        Http::fake([
            '*/api/v1/divisions/battlefield*' => Http::response(['data' => ['division' => [
                'name' => 'Battlefield',
                'slug' => 'battlefield',
                'abbreviation' => 'bf',
                'members_count' => 1,
                ...$extra,
            ]]]),
            '*/api/v1/divisions' => Http::response(['data' => [['name' => 'Battlefield', 'slug' => 'battlefield', 'show_on_site' => true]]]),
        ]);
        $this->get('/divisions/battlefield')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('division.backdropPosition', $position)
                ->missing('division.heroImagePosition'));
    })->with([
        'positioned header image' => [['hero_image' => 'https://example.com/hero.jpg', 'hero_image_position' => '30% 70%'], '30% 70%'],
        'header image without a position' => [['hero_image' => 'https://example.com/hero.jpg'], null],
        'screenshot fallback' => [['hero_image_position' => '30% 70%', 'screenshots' => [['url' => 'https://example.com/shot.jpg']]], null],
        'malformed position' => [['hero_image' => 'https://example.com/hero.jpg', 'hero_image_position' => '30% 70%; color: red'], null],
    ]);

    it('renders a division cached before positions existed', function () {
        Cache::putMany([
            'aod_division_details_battlefield' => ['found' => true, 'division' => [
                'name' => 'Battlefield',
                'slug' => 'battlefield',
                'abbreviation' => 'bf',
                'icon' => null,
                'membersCount' => 1,
                'heroImage' => 'https://example.com/hero.jpg',
                'metaDescription' => null,
                'siteContentHtml' => null,
                'screenshots' => [],
                'leadership' => [],
            ]],
            'illuminate:cache:flexible:created:aod_division_details_battlefield' => now()->getTimestamp(),
        ], 900);
        $this->get('/divisions/battlefield')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('division.backdrop', 'https://example.com/hero.jpg')
                ->where('division.backdropPosition', null));
    });

    it('returns 404 for a division the tracker does not know', function () {
        Http::fake([
            '*/api/v1/divisions' => Http::response(['data' => [['name' => 'Battlefield', 'slug' => 'battlefield']]]),
        ]);
        $this->get('/divisions/nope')->assertNotFound();
    });

    it('passes the winter season through the new year and nothing in November', function (string $date, ?string $season) {
        $this->travelTo(CarbonImmutable::parse($date));
        $this->get('/')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $season === null
                ? $page->where('season', null)
                : $page->where('season.id', $season));
    })->with([
        'early December' => ['2026-12-01', 'winter'],
        'New Year' => ['2027-01-03', 'winter'],
        'after the holidays' => ['2027-01-06', null],
        'Halloween' => ['2026-10-31', 'halloween'],
        'November' => ['2026-11-21', null],
    ]);

    it('lets search engines index every page', function (string $path) {
        Http::fake(['*/api/v1/fallen-members' => Http::response(['data' => []])]);

        $response = $this->get($path)->assertOk()->assertHeaderMissing('X-Robots-Tag');

        expect($response->getContent())->not->toContain('noindex')->not->toContain('rototype');
    })->with(['/', '/fallen-angels', '/ranks', '/code-of-conduct', '/privacy-policy', '/terms-of-use', '/android-app-privacy-policy']);

    it('redirects retired pages to their home page sections', function (string $path, string $fragment) {
        $this->get($path)->assertStatus(302)->assertRedirect(url('/') . $fragment);
    })->with([
        'history' => ['/history', '#timeline'],
        'divisions' => ['/divisions', '#divisions'],
    ]);

    it('redirects prototype links to the live pages', function (string $path, string $target) {
        $this->get($path)->assertStatus(302)->assertRedirect(url($target));
    })->with([
        'home' => ['/next', '/'],
        'home with the old key' => ['/next?key=anything', '/'],
        'ranks' => ['/next/ranks', '/ranks'],
        'division' => ['/next/divisions/battlefield', '/divisions/battlefield'],
    ]);

    it('does not redirect prototype links off the site', function (string $path) {
        $this->get($path)->assertNotFound();
    })->with(['/next/https://example.com', '/next//example.com', '/next/divisions/..%2F..%2Fexample.com']);

    it('lists only pages that render in the sitemap', function () {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee(url('/ranks'))
            ->assertSee(url('/code-of-conduct'))
            ->assertDontSee(url('/history'))
            ->assertDontSee('<loc>' . url('/divisions') . '</loc>', false);
    });
});
