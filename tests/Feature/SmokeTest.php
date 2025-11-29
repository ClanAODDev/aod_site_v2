<?php

describe('Smoke Tests', function () {
    it('loads history page successfully', function () {
        $response = $this->get(route('history'));
        $response->assertOk();
    });

    it('loads terms of use page successfully', function () {
        $response = $this->get(route('terms-of-use'));
        $response->assertOk();
    });

    it('loads privacy policy page successfully', function () {
        $response = $this->get(route('privacy-policy'));
        $response->assertOk();
    });

    it('loads android app privacy policy page successfully', function () {
        $response = $this->get(route('android-app-privacy-policy'));
        $response->assertOk();
    });

    it('loads division index page successfully', function () {
        $response = $this->get(route('division.index'));
        $response->assertOk();
    });

    it('handles basic navigation', function () {
        // Test that basic pages load without errors
        $pages = [
            '/',
            '/history',
            '/divisions',
            '/fallen-angels',
            '/privacy-policy',
            '/terms-of-use',
            '/android-app-privacy-policy',
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);
            expect($response->status())->toBe(200, "Page {$page} should return 200");
        }
    });

    it('has working health check', function () {
        $response = $this->get('/up');
        $response->assertOk();
    });
});
