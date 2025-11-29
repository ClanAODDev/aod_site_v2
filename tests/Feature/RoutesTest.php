<?php

describe('Application Routes', function () {
    it('has all expected routes registered', function () {
        $expectedRoutes = [
            'GET' => [
                '/' => 'home',
                '/history' => 'history',
                '/fallen-angels' => 'fallen-angels',
                '/divisions' => 'division.index',
                '/divisions/{division}' => 'division.show',
                '/privacy-policy' => 'privacy-policy',
                '/terms-of-use' => 'terms-of-use',
                '/android-app-privacy-policy' => 'android-app-privacy-policy',
            ],
            'REDIRECT' => [
                '/clanaod-privacy-policy' => '/privacy-policy',
            ],
        ];

        $routes = collect(app('router')->getRoutes())->keyBy(function ($route) {
            return $route->uri();
        });

        foreach ($expectedRoutes['GET'] as $uri => $name) {
            $cleanUri = ltrim($uri, '/');
            $hasRoute = $routes->has($uri) || $routes->has($cleanUri);
            expect($hasRoute)->toBeTrue("Route {$uri} should exist");

            $route = $routes->get($uri) ?? $routes->get($cleanUri);
            if ($name && $route) {
                expect($route->getName())->toBe($name, "Route {$uri} should have name {$name}");
            }
        }
    });

    it('home route works', function () {
        expect(route('home'))->toBe(url('/'));
    });

    it('history route works', function () {
        expect(route('history'))->toBe(url('/history'));
    });

    it('fallen angels route works', function () {
        expect(route('fallen-angels'))->toBe(url('/fallen-angels'));
    });

    it('division routes work', function () {
        expect(route('division.index'))->toBe(url('/divisions'));
        expect(route('division.show', 'cod'))->toBe(url('/divisions/cod'));
        expect(route('division.show', 'battlefield'))->toBe(url('/divisions/battlefield'));
    });

    it('policy routes work', function () {
        expect(route('privacy-policy'))->toBe(url('/privacy-policy'));
        expect(route('terms-of-use'))->toBe(url('/terms-of-use'));
        expect(route('android-app-privacy-policy'))->toBe(url('/android-app-privacy-policy'));
    });

    it('redirect routes work', function () {
        $response = $this->get('/clanaod-privacy-policy');
        $response->assertRedirect('/privacy-policy');
    });

    it('health check route exists', function () {
        $response = $this->get('/up');
        $response->assertOk();
    });

    it('handles 404 for non-existent routes', function () {
        $response = $this->get('/non-existent-route');
        $response->assertNotFound();
    });

    it('middleware is applied correctly', function () {
        // Test that web middleware is applied to web routes
        $response = $this->get('/');

        // Check for CSRF token in response (indicates web middleware is active)
        expect($response->headers->get('Set-Cookie'))->toContain('XSRF-TOKEN');
    });
});
