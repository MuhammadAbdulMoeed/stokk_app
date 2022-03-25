<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;

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

Route::namespace('Admin')->group(function () {
    Route::namespace("Auth")->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('/', [LoginController::class, 'loginPage'])->name('loginPage');
            Route::post('login', [LoginController::class, 'login'])->name('loginUser');

            Route::get('/forget-password', [ForgotPasswordController::class, 'forgetPasswordForm'])->name('forgetPasswordForm');
            Route::post('/forget-password', [ForgotPasswordController::class, 'forgetPassword'])->name('forgetPassword');

            Route::get('reset/password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('resetPassword');
            Route::post('change-password', [ForgotPasswordController::class, 'changePassword'])->name('changePassword');

        });

        Route::middleware(['Admin'])->group(function () {
            Route::get('logout', [LogoutController::class, 'logout'])->name('logoutUser');

        });
    });


    Route::middleware(['Admin'])->group(function () {



    });
});
