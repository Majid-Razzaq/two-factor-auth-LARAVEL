<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register', [
        AuthController::class,
        'showRegister',
    ])->name('register');

    Route::post('/register', [
        AuthController::class,
        'register',
    ])->name('register.store');

    Route::get('/login', [
        AuthController::class,
        'showLogin',
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login',
    ])->name('login.store');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Two Factor Authentication
    |--------------------------------------------------------------------------
    */

    Route::get('/verify-otp', [
        TwoFactorController::class,
        'show',
    ])->name('two-factor.show');

    Route::post('/verify-otp', [
        TwoFactorController::class,
        'verify',
    ])->name('two-factor.verify');

    Route::post('/resend-otp', [
        TwoFactorController::class,
        'resend',
    ])->name('two-factor.resend');


    /*
    |--------------------------------------------------------------------------
    | Fully Protected Application
    |--------------------------------------------------------------------------
    */

    Route::middleware('twofactor')->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        AuthController::class,
        'logout',
    ])->name('logout');
});
