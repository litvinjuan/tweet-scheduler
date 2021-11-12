<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest'])->name('auth.')->group(function () {
    Route::get('/login', [Controllers\AuthController::class, 'loginScreen'])->name('login');
    Route::post('/login', [Controllers\AuthController::class, 'login'])->name('login');

    Route::get('/redirect', [Controllers\AuthController::class, 'redirect'])->name('redirect');
    Route::get('/callback', [Controllers\AuthController::class, 'callback'])->name('callback');
});

Route::middleware(['auth'])->name('auth.')->group(function () {
    Route::post('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('/accounts')->name('accounts.')->group(function () {
        Route::get('/', [Controllers\AccountController::class, 'index'])->name('index');
        Route::get('/add', [Controllers\AccountController::class, 'redirect'])->name('add');
        Route::get('/callback', [Controllers\AccountController::class, 'callback'])->name('callback');
        Route::post('/{account:uuid}/switch', [Controllers\AccountController::class, 'switch'])->name('switch');
    });

    Route::prefix('/{account:username}')->group(function () {
        Route::get('/dashboard', [Controllers\TweetController::class, 'index'])->name('dashboard');
        Route::post('/tweet', [Controllers\TweetController::class, 'store'])->name('tweet');
    });
});
