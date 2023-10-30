<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('login')
    ->name('login.')
    ->group(function () {
        Route::get('', [AuthController::class, 'view'])
            ->name('view');
        Route::post('', [AuthController::class, 'login'])
            ->name('action');
    });

Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware('auth')
    ->group(function () {
        Route::get('', [DashboardController::class, 'index'])
            ->name('index');
        Route::get('/{idPublic}', [DashboardController::class, 'show'])
            ->name('show');
    });

