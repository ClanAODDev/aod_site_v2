<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class RepositoryClientTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function a_tracker_access_token_is_present_or_an_exception_is_thrown()
    {
        config()->set('services.aod.access_token', null);

        $this->get(route('home'))->assertSee('Tracker access token missing');

        config()->set('services.aod.access_token', 'et-consequatur-sunt-velit-ipsam');

        $this->get(route('home'))->assertOk();
    }
}
