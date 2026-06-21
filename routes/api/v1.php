<?php

declare(strict_types=1);

use App\Http\Controllers\Api\StubController;
use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/refresh-token', [AuthController::class, 'refresh'])
    ->middleware('auth:sanctum')
    ->name('refresh-token');

Route::middleware('auth:sanctum')->group(function (): void {
    Route::prefix('subscriber')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('approval-manager')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('role')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('role-handover')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('organization')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('employee/information')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('employee/type')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('employee/education')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('employee/work-experience')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('employee/project')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('employee/expertise')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('employee/competency')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('employee/certificate')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('employee/achievement')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('master/education')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('master/position')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('master/skill')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::prefix('master-competency')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });

    Route::post('/upload', [StubController::class, 'notImplemented']);
    Route::post('/upload/v2', [StubController::class, 'notImplemented']);

    Route::prefix('dropdown')->group(function (): void {
        Route::any('{any}', [StubController::class, 'notImplemented'])->where('any', '.*');
    });
});
