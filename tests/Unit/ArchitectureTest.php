<?php

describe('Architecture Tests', function () {
    it('ensures controllers extend base controller', function () {
        expect('App\Http\Controllers')
            ->toExtend('App\Http\Controllers\Controller')
            ->ignoring('App\Http\Controllers\Controller');
    });

    it('ensures repositories extend base repository', function () {
        expect('App\Repositories\AOD')
            ->toExtend('App\Repositories\AOD\Repository')
            ->ignoring('App\Repositories\AOD\Repository')
            ->ignoring('App\Repositories\AOD\TwitchRepository');
    });

    it('ensures controllers are in correct namespace', function () {
        expect('App\Http\Controllers')
            ->toBeClasses()
            ->toHaveSuffix('Controller');
    });

    it('ensures repositories are in correct namespace', function () {
        expect('App\Repositories')
            ->toBeClasses()
            ->toHaveSuffix('Repository');
    });

    it('ensures no debugging functions are used', function () {
        expect(['dd', 'dump', 'var_dump', 'print_r'])
            ->not->toBeUsed();
    });

    it('ensures strict types are declared', function () {
        expect('App')
            ->toUseStrictTypes();
    });

    it('ensures controllers have proper return types', function () {
        expect('App\Http\Controllers')
            ->classes()
            ->toExtend('App\Http\Controllers\Controller');
    });

    it('ensures no global variables are used', function () {
        expect('App')
            ->not->toUse(['$GLOBALS', '$_GET', '$_POST', '$_SESSION', '$_COOKIE']);
    });

    it('ensures proper exception handling', function () {
        expect('App\Repositories')
            ->classes()
            ->toUse('Illuminate\Http\Client\Response');
    });

    it('ensures controllers use proper HTTP methods', function () {
        expect('App\Http\Controllers')
            ->classes()
            ->toExtend('App\Http\Controllers\Controller');
    });

    it('ensures repositories use HTTP client', function () {
        expect('App\Repositories\AOD')
            ->toUse([
                'Illuminate\Http\Client\PendingRequest',
                'Illuminate\Http\Client\Response',
                'Illuminate\Support\Facades\Http',
            ]);
    });

    it('ensures no direct database queries in controllers', function () {
        expect('App\Http\Controllers')
            ->not->toUse([
                'Illuminate\Support\Facades\DB',
                'Illuminate\Database\Query\Builder',
            ]);
    });

    it('ensures proper dependency injection', function () {
        expect('App\Http\Controllers')
            ->toUse(['App\Repositories']);
    });
});
