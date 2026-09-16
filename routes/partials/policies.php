<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/privacy-policy', fn () => Inertia::render('pages/privacy-policy')->withViewData([
    'metaTitle' => 'Privacy Policy | Angels of Death',
]))->name('privacy-policy');
Route::redirect('/clanaod-privacy-policy', '/privacy-policy');

Route::get('/terms-of-use', fn () => Inertia::render('pages/terms-of-use')->withViewData([
    'metaTitle' => 'Terms of Use | Angels of Death',
]))->name('terms-of-use');

Route::get('/android-app-privacy-policy', fn () => Inertia::render('pages/android-app-privacy-policy')->withViewData([
    'metaTitle' => 'Android App Privacy Policy | Angels of Death',
]))->name('android-app-privacy-policy');
