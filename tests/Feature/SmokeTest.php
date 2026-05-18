<?php

describe('Smoke Tests', function () {
    it('loads page successfully', function (string $path) {
        $this->get($path)->assertOk();
    })->with([
        'home' => '/',
        'history' => '/history',
        'divisions' => '/divisions',
        'fallen-angels' => '/fallen-angels',
        'privacy-policy' => '/privacy-policy',
        'terms-of-use' => '/terms-of-use',
        'android-app-privacy-policy' => '/android-app-privacy-policy',
    ]);

    it('has working health check', function () {
        $this->get('/up')->assertOk();
    });
});
