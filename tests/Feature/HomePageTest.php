<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /** @test */
    public function home_page_returns_200_ok()
    {
        $tsResponse = file_get_contents(storage_path(
            'testing/teamspeak.json'
        ));

        $discordResponse = file_get_contents(storage_path(
            'testing/discord.json'
        ));

        Http::fake([
            "*/api/v1/ts-count" => Http::response($tsResponse, 200),
            "*/api/v1/discord-count" => Http::response($discordResponse, 200),
        ]);

        $data = $this->get(route('home'));

        $data->assertOk();
    }

    /** @test */
    public function home_page_returns_200_ok_if_twitter_lookup_fails()
    {
        $discordResponse = file_get_contents(storage_path(
            'testing/discord.json'
        ));

        Http::fake([
            "*/api/v1/ts-count" => Http::response([], 500),
            "*/api/v1/discord-count" => Http::response($discordResponse, 200),
        ]);

        $data = $this->get(route('home'));

        $data->assertOk();
    }

    /** @test */
    public function home_page_returns_200_ok_if_discord_lookup_fails()
    {
        $tsResponse = file_get_contents(storage_path(
            'testing/teamspeak.json'
        ));

        Http::fake([
            "*/api/v1/ts-count" => Http::response($tsResponse, 200),
            "*/api/v1/discord-count" => Http::response([], 500),
        ]);

        $data = $this->get(route('home'));

        $data->assertOk();
    }

    /** @test */
    public function home_page_returns_200_ok_if_rss_announcements_lookup_fails()
    {
        Http::fake([
            'clanaod.net/forums/external.php*' => Http::response([], 500)
        ]);

        $data = $this->get(route('home'));

        $data->assertOk();
    }
}
