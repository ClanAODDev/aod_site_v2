<?php

use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FallenAngelsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TrackerDivisionWebhookController;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

if (app()->environment('local')) {
    Route::get('_dev/gallery', fn () => Inertia::render('dev/gallery'))->name('dev.gallery');
}

Route::post('/webhooks/tracker/divisions', TrackerDivisionWebhookController::class)
    ->withoutMiddleware(HandleInertiaRequests::class)
    ->middleware('throttle:30,1')
    ->name('webhooks.tracker.divisions');

Route::get('/', HomeController::class)->name('home');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/history', fn () => redirect()->to(route('home') . '#timeline'))->name('history');

Route::get('/fallen-angels', FallenAngelsController::class)->name('fallen-angels');
Route::get('/ranks', [PageController::class, 'ranks'])->name('ranks');
Route::get('/code-of-conduct', [PageController::class, 'codeOfConduct'])->name('code-of-conduct');
Route::get('/divisions', fn () => redirect()->to(route('home') . '#divisions'))->name('division.index');
Route::get('/divisions/{division}', [DivisionController::class, 'show'])->name('division.show');

Route::get('/next/{path?}', fn (string $path = '') => redirect()->to(url('/' . $path)))
    ->where('path', 'fallen-angels|ranks|code-of-conduct|divisions/[A-Za-z0-9-]+');

require 'partials/policies.php';
