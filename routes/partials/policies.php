<?php

use Illuminate\Support\Facades\Route;

Route::view('/privacy-policy', 'pages.privacy-policy')->name('privacy-policy');
Route::redirect('/clanaod-privacy-policy', '/privacy-policy');

Route::view('/terms-of-use', 'pages.terms-of-use')->name('terms-of-use');
Route::view('/android-app-privacy-policy', 'pages.android-app-privacy-policy')->name('android-app-privacy-policy');
