<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\CategoryFilterController;

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
        Route::get('dashboard',[DashboardController::class,'index'])->name('adminDashboard');

        Route::get('profile',[ProfileController::class,'index'])->name('adminProfile');
        Route::post('save-profile',[ProfileController::class,'save'])->name('adminProfileSave');

        Route::get('category-listing',[CategoryController::class,'index'])->name('categoryListing');
        Route::get('create-category',[CategoryController::class,'create'])->name('categoryCreate');
        Route::post('save-category',[CategoryController::class,'save'])->name('categorySave');
        Route::get('edit-category/{id}',[CategoryController::class,'edit'])->name('categoryEdit');
        Route::post('update-category',[CategoryController::class,'update'])->name('categoryUpdate');
        Route::post('delete-category',[CategoryController::class,'delete'])->name('categoryDelete');
        Route::get('category-change-status',[CategoryController::class,'status'])->name('categoryChangeStatus');

        Route::get('filter-listing',[FilterController::class,'index'])->name('filterListing');
        Route::get('create-filter',[FilterController::class,'create'])->name('filterCreate');
        Route::post('save-filter',[FilterController::class,'save'])->name('filterSave');
        Route::get('edit-filter/{id}',[FilterController::class,'edit'])->name('filterEdit');
        Route::post('update-filter',[FilterController::class,'update'])->name('filterUpdate');
        Route::post('delete-filter',[FilterController::class,'delete'])->name('filterDelete');
        Route::get('filter-change-status',[FilterController::class,'status'])->name('filterChangeStatus');

        Route::get('category-filter-listing',[CategoryFilterController::class,'index'])->name('categoryFilterListing');
        Route::get('create-category-filter',[CategoryFilterController::class,'create'])->name('categoryFilterCreate');
        Route::post('save-category-filter',[CategoryFilterController::class,'save'])->name('categoryFilterSave');
        Route::get('edit-category-filter/{id}',[CategoryFilterController::class,'edit'])->name('categoryFilterEdit');
        Route::post('update-category-filter',[CategoryFilterController::class,'update'])->name('categoryFilterUpdate');
        Route::post('delete-category-filter',[CategoryFilterController::class,'delete'])->name('categoryFilterDelete');
        Route::get('category-filter-change-status',[CategoryFilterController::class,'status'])->name('categoryFilterChangeStatus');

    });
});
