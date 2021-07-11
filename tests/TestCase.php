<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $divisionalData = file_get_contents(storage_path(
            'testing/divisions.json'
        ));

        $announcementsData = file_get_contents(storage_path(
            'testing/announcements.xml'
        ));

        $twitterData = file_get_contents(storage_path(
            'testing/tweets.json'
        ));

        Http::fake([
            '*/api/v1/divisions' => Http::response($divisionalData, 200),
            '*/external.php?type=RSS2&forumids=102' => Http::response($announcementsData, 200),
            '*/statuses/user_timeline.json' => Http::response($twitterData, 200),
        ]);
    }
}
