<?php

use App\Http\Controllers\ScreenshotController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ScreenshotController::class, 'index']);
Route::post('/', [ScreenshotController::class, 'store'])->name('store');
