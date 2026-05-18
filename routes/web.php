<?php

use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FallenAngelsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::view('/history', 'pages.history')->name('history');

Route::get('/fallen-angels', FallenAngelsController::class)->name('fallen-angels');
Route::get('/divisions', [DivisionController::class, 'index'])->name('division.index');
Route::get('/divisions/{division}', [DivisionController::class, 'show'])->name('division.show');

require 'partials/policies.php';
