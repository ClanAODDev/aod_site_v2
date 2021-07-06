<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    /** @test */
    public function the_home_page_returns_200_ok()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function the_divisions_index_returns_200_ok()
    {
        $response = $this->get('/divisions');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_single_division_page_returns_200_ok()
    {
        // matches a division in our test data
        $response = $this->get('/divisions/tom-clancy');

        $response->assertStatus(200);
    }
}
