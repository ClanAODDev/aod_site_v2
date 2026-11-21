<?php

use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FallenAngelsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrototypeController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\RequirePrototypeAccess;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

if (app()->environment('local')) {
    Route::get('_dev/gallery', fn () => Inertia::render('dev/gallery'))->name('dev.gallery');
}

Route::get('/', HomeController::class)->name('home');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/history', HistoryController::class)->name('history');

Route::get('/fallen-angels', FallenAngelsController::class)->name('fallen-angels');
Route::get('/divisions', [DivisionController::class, 'index'])->name('division.index');
Route::get('/divisions/{division}', [DivisionController::class, 'show'])->name('division.show');

Route::prefix('next')->name('prototype.')->middleware(RequirePrototypeAccess::class)->controller(PrototypeController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/fallen-angels', 'fallenAngels')->name('fallen-angels');
    Route::get('/divisions/{division}', 'division')->name('division');
});

require 'partials/policies.php';
