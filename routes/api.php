<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\UserLocationController;
use App\Http\Controllers\Api\CategoryFilterController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CategoryFieldController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\BlockUserController;
use App\Http\Controllers\Api\MyProductController;
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

Route::group(['middleware' => ['json.response']], function () {
    Route::namespace('Api')->group(function () {
        Route::post('login', [LoginController::class, 'emailLogin']);
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('social-login', [LoginController::class, 'socialLogin']);
        Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
        Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
        Route::post('change-password', [ForgotPasswordController::class, 'updatePassword']);
        Route::post('resend-otp', [ForgotPasswordController::class, 'resendOTP']);

        Route::middleware('auth:api')->group(function () {

            Route::post('logout', [LogoutController::class, 'logout']);

        });

    });
    Route::namespace('Api')->group(function () {

        Route::middleware('auth:api')->group(function () {

            Route::post('save-user-location', [UserLocationController::class, 'save']);
            Route::post('category-field',[CategoryFieldController::class,'getCategoryField']);
            Route::post('home',[HomeController::class,'index']);
            Route::post('search',[HomeController::class,'searchProduct']);

            Route::post('get-profile',[ProfileController::class,'profile']);
            Route::post('save-profile',[ProfileController::class,'saveProfile']);

            Route::post('get-all-category',[CategoryController::class,'getCategories']);
            Route::post('search-category',[CategoryController::class,'searchCategory']);

            Route::post('get-category-filter',[CategoryFilterController::class,'getCategoryFilter']);
            Route::post('apply-filters',[CategoryFilterController::class,'applyFilter']);

            Route::post('favorite-product',[FavoriteController::class,'favoriteProduct']);

            Route::post('block-user',[BlockUserController::class,'blockUser']);
            Route::post('unblock-user',[BlockUserController::class,'unBlockUser']);

            Route::post('my-products',[MyProductController::class,'myProduct']);

            Route::post('get-subcategory-product',[CategoryController::class,'getSubCategoryProduct']);

        });

    });

});
