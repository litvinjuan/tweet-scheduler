<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/', function () {
    return \Inertia\Inertia::render('Home');
});

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::get('/redirect', [Controllers\AuthController::class, 'redirect'])->name('redirect');
    Route::get('/callback', [Controllers\AuthController::class, 'callback'])->name('callback');
});
