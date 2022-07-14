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
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ChatController;
/*
|------------------------------------------------.
--------------------------
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
            Route::get('category-field',[CategoryFieldController::class,'getCategoryField']);
            Route::post('home',[HomeController::class,'index']);
            Route::post('search',[HomeController::class,'searchProduct']);

            Route::get('get-profile',[ProfileController::class,'profile']);
            Route::post('save-profile',[ProfileController::class,'saveProfile']);

            Route::get('get-all-category',[CategoryController::class,'getCategories']);
            Route::post('search-category',[CategoryController::class,'searchCategory']);

            Route::get('get-category-filter',[CategoryFilterController::class,'getCategoryFilter']);
            Route::post('apply-filters',[CategoryFilterController::class,'applyFilter']);

            Route::post('make-product-favorite',[FavoriteController::class,'favoriteProduct']);
            Route::get('favorite-product-list',[FavoriteController::class,'favoriteProductList']);


            Route::post('block-user',[BlockUserController::class,'blockUser']);
            Route::post('unblock-user',[BlockUserController::class,'unBlockUser']);

            Route::get('my-products',[MyProductController::class,'myProduct']);

            Route::get('get-products',[CategoryController::class,'getProduct']);
            Route::get('get-subcategory',[CategoryController::class,'getSubCategory']);

            Route::post('save-product',[ProductController::class,'save']);

            Route::get('product-detail',[ProductController::class,'productDetail']);

            Route::post('post-review',[ReviewController::class,'saveReview']);

            Route::get('conversation',[ChatController::class,'conversation']);
            Route::post('send-message',[ChatController::class,'sendMessage']);
            Route::get('chat-list',[ChatController::class,'chat']);

        });

    });

});
