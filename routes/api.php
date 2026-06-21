<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Root aggregator — versioned routes live in routes/api/v1.php
| (see docs/ARCHITECTURE.md §8 Lapisan API).
|
*/

Route::prefix('v1')
    ->name('api.v1.')
    ->group(base_path('routes/api/v1.php'));

// Backward compatibility for existing mobile clients.
Route::post('/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login']);
Route::post('/refresh-token', [\App\Http\Controllers\Api\V1\AuthController::class, 'refresh'])
    ->middleware('auth:sanctum');
