<?php

describe('Application Configuration', function () {
    it('has required environment variables', function () {
        $requiredEnvVars = [
            'APP_NAME',
            'APP_ENV',
            'APP_KEY',
            'APP_DEBUG',
            'APP_URL',
        ];

        foreach ($requiredEnvVars as $var) {
            expect(env($var))->not->toBeNull("Environment variable {$var} should be set");
        }
    });

    it('has correct app configuration', function () {
        expect(config('app.name'))->not->toBeNull();
        expect(config('app.env'))->toBeIn(['local', 'testing', 'staging', 'production']);
        expect(config('app.debug'))->toBeIn([true, false]);
        expect(config('app.url'))->toStartWith('http');
        expect(config('app.timezone'))->toBe('UTC');
        expect(config('app.locale'))->toBe('en');
        expect(config('app.fallback_locale'))->toBe('en');
    });

    it('has cache configuration', function () {
        expect(config('app.cache_length'))->not->toBeNull();
        expect(config('app.cache_length'))->toBeInt();
    });

    it('has AOD service configuration', function () {
        // These might be null in testing, but the config keys should exist
        expect(config()->has('services.aod.access_token'))->toBeTrue();
        expect(config()->has('services.aod.tracker_url'))->toBeTrue();
    });

    it('has fallen angels configuration', function () {
        expect(config()->has('aod.fallen-angels'))->toBeTrue();
    });

    it('has database configuration', function () {
        expect(config('database.default'))->not->toBeNull();
        expect(config('database.connections'))->toBeArray();
        expect(config('database.connections'))->not->toBeEmpty();
    });

    it('has session configuration', function () {
        expect(config('session.driver'))->not->toBeNull();
        expect(config('session.lifetime'))->toBeNumeric();
        expect(config('session.expire_on_close'))->toBeIn([true, false]);
        expect(config('session.encrypt'))->toBeIn([true, false]);
        expect(config('session.cookie'))->not->toBeNull();
    });

    it('has mail configuration', function () {
        expect(config('mail.default'))->not->toBeNull();
        expect(config('mail.mailers'))->toBeArray();
    });

    it('has logging configuration', function () {
        expect(config('logging.default'))->not->toBeNull();
        expect(config('logging.channels'))->toBeArray();
        expect(config('logging.channels'))->not->toBeEmpty();
    });

    it('has filesystem configuration', function () {
        expect(config('filesystems.default'))->not->toBeNull();
        expect(config('filesystems.disks'))->toBeArray();
        expect(config('filesystems.disks'))->not->toBeEmpty();
    });

    it('has queue configuration', function () {
        expect(config('queue.default'))->not->toBeNull();
        expect(config('queue.connections'))->toBeArray();
    });

    it('has broadcasting configuration', function () {
        expect(config('broadcasting.default'))->not->toBeNull();
        expect(config('broadcasting.connections'))->toBeArray();
    });
});
