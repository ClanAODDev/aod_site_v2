<?php

use App\Repositories\AOD\DivisionRepository;
use App\Support\OnSiteDivisions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Testing\AssertableInertia;

describe('Tracker outages', function () {
    beforeEach(function () {
        Cache::flush();
    });

    it('renders pages with an empty division list when the tracker is unreachable', function () {
        $this->fakeHttp(['*' => Http::failedConnection()]);

        $this->get(route('history'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('divisions', []));
    });

    it('does not cache an empty division list after a failed request', function () {
        $this->fakeHttp(['*/api/v1/divisions' => Http::response([], 500)]);

        $this->get(route('history'))->assertOk();

        expect(Cache::get(OnSiteDivisions::CACHE_KEY))->toBeNull();
    });

    it('keeps serving the last good division list while the tracker is down', function () {
        $this->fakeHttp([
            '*/api/v1/divisions' => Http::response(['data' => [
                ['name' => 'Battlefield', 'slug' => 'battlefield', 'show_on_site' => true],
            ]], 200),
        ]);

        $this->get(route('history'))->assertOk();
        $cached = Cache::get(OnSiteDivisions::CACHE_KEY);
        expect($cached)->not->toBeEmpty();

        $this->travel(config('app.cache_length') + 1)->seconds();
        Facade::clearResolvedInstance(DivisionRepository::class);
        $this->fakeHttp(['*' => Http::failedConnection()]);
        $this->withoutDefer();
        Log::spy();

        $this->get(route('history'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('divisions', $cached));

        expect(Cache::get(OnSiteDivisions::CACHE_KEY))->toBe($cached);
        Log::shouldHaveReceived('warning')->once();
    });

    it('shows the home page without a discord count when the tracker is unreachable', function () {
        $this->fakeHttp(['*' => Http::failedConnection()]);

        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('discord', null));
    });

    it('shows the home page when twitch is unreachable', function () {
        config()->set('services.twitch.client_id', 'client-id');
        config()->set('services.twitch.client_secret', 'client-secret');
        $this->fakeHttp(['*' => Http::failedConnection()]);

        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('twitch.is_live', false));
    });

    it('shows fallen angels with an empty list when the tracker is unreachable', function () {
        $this->fakeHttp(['*' => Http::failedConnection()]);

        $this->get(route('fallen-angels'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('fallen', []));
    });

    it('returns 503 for a division page when the tracker is unreachable', function () {
        $this->fakeHttp(['*' => Http::failedConnection()]);

        $this->get(route('division.show', 'battlefield'))->assertServiceUnavailable();
    });

    it('returns 503 for a division page when the tracker rejects the token', function () {
        $this->fakeHttp([
            '*/api/v1/divisions/battlefield*' => Http::response([], 401),
            '*/api/v1/divisions' => Http::response(['data' => []], 200),
        ]);

        $this->get(route('division.show', 'battlefield'))->assertServiceUnavailable();
    });

    it('returns 404 for a division page the tracker does not know', function () {
        $this->fakeHttp([
            '*/api/v1/divisions/nope*' => Http::response([], 404),
            '*/api/v1/divisions' => Http::response(['data' => []], 200),
        ]);

        $this->get(route('division.show', 'nope'))->assertNotFound();
    });
});
