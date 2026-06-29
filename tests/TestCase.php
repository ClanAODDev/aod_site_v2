<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
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
        ]);
    }
}
