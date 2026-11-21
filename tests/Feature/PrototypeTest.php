<?php

use App\Http\Middleware\RequirePrototypeAccess;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia;

describe('Prototype', function () {
    beforeEach(function () {
        Cache::flush();
        config(['aod.prototype.access_key' => 'open-sesame']);

        Http::fake([
            '*/api/v1/discord-count' => Http::response(json_decode(file_get_contents(storage_path('testing/discord.json')), true)),
            '*/api/v1/divisions' => Http::response(json_decode(file_get_contents(storage_path('testing/divisions.json')), true)),
        ]);
    });

    it('is hidden when no access key is configured', function () {
        config(['aod.prototype.access_key' => null]);

        $this->get('/next?key=anything')->assertNotFound();
    });

    it('is hidden without the cookie', function () {
        $this->get('/next')->assertNotFound();
    });

    it('rejects the wrong key', function () {
        $this->get('/next?key=wrong')->assertNotFound()->assertCookieMissing(RequirePrototypeAccess::COOKIE);
    });

    it('sets the cookie and drops the key from the URL', function () {
        $this->get('/next?key=open-sesame')
            ->assertRedirect(url('/next'))
            ->assertCookie(RequirePrototypeAccess::COOKIE)
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    });

    it('renders for a browser holding the cookie', function () {
        $grant = hash_hmac('sha256', 'open-sesame', config('app.key'));

        $this->withCookie(RequirePrototypeAccess::COOKIE, $grant)
            ->get('/next')
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('next/home')
                ->where('foundedYear', 1999)
                ->where('currentYear', (int) now()->year)
                ->has('discord')
                ->has('twitch.vods')
                ->has('twitch.channel'));
    });

    it('stops letting a cookie in once the key changes', function () {
        $grant = hash_hmac('sha256', 'open-sesame', config('app.key'));
        config(['aod.prototype.access_key' => 'new-key']);

        $this->withCookie(RequirePrototypeAccess::COOKIE, $grant)->get('/next')->assertNotFound();
    });

    it('gates the fallen angels and division pages too', function () {
        $this->get('/next/fallen-angels')->assertNotFound();
        $this->get('/next/divisions/battlefield')->assertNotFound();
    });

    it('renders the fallen angels page', function () {
        Http::fake([
            '*/api/v1/fallen-members' => Http::response(json_decode(file_get_contents(storage_path('testing/fallen-members.json')), true)),
        ]);
        $grant = hash_hmac('sha256', 'open-sesame', config('app.key'));

        $this->withCookie(RequirePrototypeAccess::COOKIE, $grant)
            ->get('/next/fallen-angels')
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
                'description' => 'Squad up.',
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
        $grant = hash_hmac('sha256', 'open-sesame', config('app.key'));

        $response = $this->withCookie(RequirePrototypeAccess::COOKIE, $grant)
            ->get('/next/divisions/battlefield')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('next/division')
                ->where('division.name', 'Battlefield')
                ->where('division.membersCount', 233)
                ->where('division.leadership.0.rank', 'Sgt')
                ->where('division.leadership.0', fn ($leader) => ! collect($leader)->has('discord_id')));

        expect($response->getContent())->not->toContain('444444444444444444');
    });

    it('returns 404 for a division the tracker does not know', function () {
        Http::fake([
            '*/api/v1/divisions' => Http::response(['data' => [['name' => 'Battlefield', 'slug' => 'battlefield']]]),
        ]);
        $grant = hash_hmac('sha256', 'open-sesame', config('app.key'));

        $this->withCookie(RequirePrototypeAccess::COOKIE, $grant)->get('/next/divisions/nope')->assertNotFound();
    });

    it('passes the winter season through the new year and nothing in November', function (string $date, ?string $season) {
        $this->travelTo(CarbonImmutable::parse($date));
        $grant = hash_hmac('sha256', 'open-sesame', config('app.key'));

        $this->withCookie(RequirePrototypeAccess::COOKIE, $grant)
            ->get('/next')
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

    it('leaves the current home page alone', function () {
        $this->get(route('home'))->assertOk()->assertInertia(fn (AssertableInertia $page) => $page->component('home'));
    });
});
