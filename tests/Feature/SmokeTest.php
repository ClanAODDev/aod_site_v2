<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    /** @test */
    public function the_home_page_returns_200_ok()
    {
        $this->get('/')->assertOk();
    }

    /** @test */
    public function the_divisions_index_returns_200_ok()
    {
        $this->get('/divisions')->assertOk();
    }

    /** @test */
    public function the_history_page_returns_200_ok()
    {
        $this->get('/history')->assertOk();
    }
}
