<?php

describe('Application Configuration', function () {
    it('has required environment variable', function (string $var) {
        expect(env($var))->not->toBeNull();
    })->with(['APP_NAME', 'APP_ENV', 'APP_KEY', 'APP_DEBUG', 'APP_URL']);

    it('has correct app configuration', function () {
        expect(config('app.name'))->not->toBeNull()
            ->and(config('app.env'))->toBeIn(['local', 'testing', 'staging', 'production'])
            ->and(config('app.debug'))->toBeIn([true, false])
            ->and(config('app.url'))->toStartWith('http')
            ->and(config('app.timezone'))->toBe('UTC')
            ->and(config('app.locale'))->toBe('en')
            ->and(config('app.fallback_locale'))->toBe('en');
    });

    it('has cache configuration', function () {
        expect(config('app.cache_length'))->not->toBeNull()->toBeInt();
    });

    it('has AOD service configuration', function () {
        expect(config()->has('services.aod.access_token'))->toBeTrue()
            ->and(config()->has('services.aod.tracker_url'))->toBeTrue();
    });

    it('has fallen angels configuration', function () {
        expect(config()->has('aod.fallen-angels'))->toBeTrue();
    });

    it('has database configuration', function () {
        expect(config('database.default'))->not->toBeNull()
            ->and(config('database.connections'))->toBeArray()->not->toBeEmpty();
    });

    it('has session configuration', function () {
        expect(config('session.driver'))->not->toBeNull()
            ->and(config('session.lifetime'))->toBeNumeric()
            ->and(config('session.expire_on_close'))->toBeIn([true, false])
            ->and(config('session.encrypt'))->toBeIn([true, false])
            ->and(config('session.cookie'))->not->toBeNull();
    });

    it('has mail configuration', function () {
        expect(config('mail.default'))->not->toBeNull()
            ->and(config('mail.mailers'))->toBeArray();
    });

    it('has logging configuration', function () {
        expect(config('logging.default'))->not->toBeNull()
            ->and(config('logging.channels'))->toBeArray()->not->toBeEmpty();
    });

    it('has filesystem configuration', function () {
        expect(config('filesystems.default'))->not->toBeNull()
            ->and(config('filesystems.disks'))->toBeArray()->not->toBeEmpty();
    });

    it('has queue configuration', function () {
        expect(config('queue.default'))->not->toBeNull()
            ->and(config('queue.connections'))->toBeArray();
    });

    it('has broadcasting configuration', function () {
        expect(config('broadcasting.default'))->not->toBeNull()
            ->and(config('broadcasting.connections'))->toBeArray();
    });
});
