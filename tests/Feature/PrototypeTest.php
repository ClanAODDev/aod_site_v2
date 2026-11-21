<?php

use App\Http\Middleware\RequirePrototypeAccess;
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
                ->has('discord'));
    });

    it('stops letting a cookie in once the key changes', function () {
        $grant = hash_hmac('sha256', 'open-sesame', config('app.key'));
        config(['aod.prototype.access_key' => 'new-key']);

        $this->withCookie(RequirePrototypeAccess::COOKIE, $grant)->get('/next')->assertNotFound();
    });

    it('leaves the current home page alone', function () {
        $this->get(route('home'))->assertOk()->assertInertia(fn (AssertableInertia $page) => $page->component('home'));
    });
});
