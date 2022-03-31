<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['json.response'], ['namespace' => 'Api']], function () {
//    Route::namespace('Api')->group(function () {
    Route::post('login', [LoginController::class, 'emailLogin']);
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('social-login', [LoginController::class, 'socialLogin']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
    Route::post('change-password', [ForgotPasswordController::class, 'updatePassword']);
    Route::post('resend-otp', [ForgotPasswordController::class, 'resendOTP']);

    Route::middleware('auth:api')->group(function () {

        Route::post('check', function () {
            dd('i am auth');
        });

    });

//    });
});
