<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    /**
     * @test
     * @dataProvider staticPageRouteProvider
     */
    public function static_pages_should_return_200_ok($route)
    {
        $status = $this->get(route($route))->assertOk();
    }

    public function staticPageRouteProvider(): array
    {
        return [
            'home' => ['home'],
            'history' => ['history'],
            'terms of use' => ['terms-of-use'],
            'privacy policy' => ['privacy-policy'],
            'android app privacy policy' => ['android-app-privacy-policy'],
        ];
    }
}
