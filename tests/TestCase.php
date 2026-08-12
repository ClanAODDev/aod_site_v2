<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'clanaod.net/forums/external.php*' => Http::response(
                file_get_contents(storage_path('testing/announcements.xml')), 200
            ),
            'tracker.clanaod.net/api/v1/divisions' => Http::response(
                file_get_contents(storage_path('testing/divisions.json')), 200
            ),
            'tracker.clanaod.net/api/v1/discord-count' => Http::response(
                file_get_contents(storage_path('testing/discord.json')), 200
            ),
            'tracker.clanaod.net/api/v1/fallen-members' => Http::response(
                file_get_contents(storage_path('testing/fallen-members.json')), 200
            ),
        ]);
    }

    /**
     * Replace the default HTTP fakes registered in setUp() with the given
     * stubs. Http::fake() only appends to the existing stub list and the
     * first matching stub wins, so a plain Http::fake() call inside a test
     * can never override a URL already stubbed above — this swaps in a
     * fresh client first so the new stubs are the only ones in effect.
     */
    protected function fakeHttp(array $stubs): void
    {
        Http::swap(new HttpFactory);

        Http::fake($stubs);
    }
}
