<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {

        Route::post('login', [AuthController::class, 'login'])
            ->name('login');

        Route::post('logout', [AuthController::class, 'logout'])
            ->name('logout');
    });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('client')
        ->name('client.')
        ->group(function () {
            Route::get('', [ClientController::class, 'all'])
                ->name('all');

            Route::get('/{idPublic}', [ClientController::class, 'find'])
                ->name('find');

            Route::post('', [ClientController::class, 'store'])
                ->name('store');

            Route::put('', [ClientController::class, 'update'])
                ->name('update');

            Route::delete('/{idPublic}', [ClientController::class, 'delete'])
                ->name('delete');
        });
});
