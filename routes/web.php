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
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\ItemConditionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\AdditionalOptionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ClothingTypeController;
use App\Http\Controllers\Admin\CustomFieldController;
use App\Http\Controllers\Admin\CategoryCustomFieldController;
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

        Route::middleware(['auth'])->group(function () {
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
        Route::get('category-filter-change-position/{id}',[CategoryFilterController::class,'changePosition'])->name('categoryFilterChangePosition');
        Route::post('category-filter-update-position',[CategoryFilterController::class,'updatePosition'])->name('categoryFilterUpdatePosition');

        Route::get('brand-listing',[BrandController::class,'index'])->name('brandListing');
        Route::get('create-brand',[BrandController::class,'create'])->name('brandCreate');
        Route::post('save-brand',[BrandController::class,'save'])->name('brandSave');
        Route::get('edit-brand/{id}',[BrandController::class,'edit'])->name('brandEdit');
        Route::post('update-brand',[BrandController::class,'update'])->name('brandUpdate');
        Route::post('delete-brand',[BrandController::class,'delete'])->name('brandDelete');
        Route::get('brand-change-status',[BrandController::class,'status'])->name('brandChangeStatus');

        Route::get('get-subCategory',[BrandController::class,'getSubCategory'])->name('getSubCategory');

        Route::get('class-listing',[ClassController::class,'index'])->name('classListing');
        Route::get('create-class',[ClassController::class,'create'])->name('classCreate');
        Route::post('save-class',[ClassController::class,'save'])->name('classSave');
        Route::get('edit-class/{id}',[ClassController::class,'edit'])->name('classEdit');
        Route::post('update-class',[ClassController::class,'update'])->name('classUpdate');
        Route::post('delete-class',[ClassController::class,'delete'])->name('classDelete');
        Route::get('class-change-status',[ClassController::class,'status'])->name('classChangeStatus');

        Route::get('item-condition-listing',[ItemConditionController::class,'index'])->name('itemConditionListing');
        Route::get('create-item-condition',[ItemConditionController::class,'create'])->name('itemConditionCreate');
        Route::post('save-item-condition',[ItemConditionController::class,'save'])->name('itemConditionSave');
        Route::get('edit-item-condition/{id}',[ItemConditionController::class,'edit'])->name('itemConditionEdit');
        Route::post('update-item-condition',[ItemConditionController::class,'update'])->name('itemConditionUpdate');
        Route::post('delete-item-condition',[ItemConditionController::class,'delete'])->name('itemConditionDelete');
        Route::get('item-condition-change-status',[ItemConditionController::class,'status'])->name('itemConditionChangeStatus');

        Route::get('user-listing',[UserController::class,'index'])->name('userListing');
        Route::get('create-user',[UserController::class,'create'])->name('userCreate');
        Route::post('save-user',[UserController::class,'save'])->name('userSave');
        Route::get('edit-user/{id}',[UserController::class,'edit'])->name('userEdit');
        Route::post('update-user',[UserController::class,'update'])->name('userUpdate');
        Route::post('delete-user',[UserController::class,'delete'])->name('userDelete');

        Route::get('size-listing',[SizeController::class,'index'])->name('sizeListing');
        Route::get('create-size',[SizeController::class,'create'])->name('sizeCreate');
        Route::post('save-size',[SizeController::class,'save'])->name('sizeSave');
        Route::get('edit-size/{id}',[SizeController::class,'edit'])->name('sizeEdit');
        Route::post('update-size',[SizeController::class,'update'])->name('sizeUpdate');
        Route::post('delete-size',[SizeController::class,'delete'])->name('sizeDelete');
        Route::get('size-change-status',[SizeController::class,'status'])->name('sizeChangeStatus');

        Route::get('additional-option-listing',[AdditionalOptionController::class,'index'])->name('additionalOptionListing');
        Route::get('create-additional-option',[AdditionalOptionController::class,'create'])->name('additionalOptionCreate');
        Route::post('save-additional-option',[AdditionalOptionController::class,'save'])->name('additionalOptionSave');
        Route::get('edit-additional-option/{id}',[AdditionalOptionController::class,'edit'])->name('additionalOptionEdit');
        Route::post('update-additional-option',[AdditionalOptionController::class,'update'])->name('additionalOptionUpdate');
        Route::post('delete-additional-option',[AdditionalOptionController::class,'delete'])->name('additionalOptionDelete');
        Route::get('additional-option-change-status',[AdditionalOptionController::class,'status'])->name('additionalOptionChangeStatus');

        Route::get('cloth-type-listing',[ClothingTypeController::class,'index'])->name('clothTypeListing');
        Route::get('create-cloth-type',[ClothingTypeController::class,'create'])->name('clothTypeCreate');
        Route::post('save-cloth-type',[ClothingTypeController::class,'save'])->name('clothTypeSave');
        Route::get('edit-cloth-type/{id}',[ClothingTypeController::class,'edit'])->name('clothTypeEdit');
        Route::post('update-cloth-type',[ClothingTypeController::class,'update'])->name('clothTypeUpdate');
        Route::post('delete-cloth-type',[ClothingTypeController::class,'delete'])->name('clothTypeDelete');
        Route::get('cloth-type-change-status',[ClothingTypeController::class,'status'])->name('clothTypeChangeStatus');

        Route::get('custom-field-listing',[CustomFieldController::class,'index'])->name('customFieldsListing');
        Route::get('create-custom-field',[CustomFieldController::class,'create'])->name('customFieldsCreate');
        Route::post('save-custom-field',[CustomFieldController::class,'save'])->name('customFieldsSave');
        Route::get('edit-custom-field/{id}',[CustomFieldController::class,'edit'])->name('customFieldsEdit');
        Route::post('update-custom-field',[CustomFieldController::class,'update'])->name('customFieldsUpdate');
        Route::post('delete-custom-field',[CustomFieldController::class,'delete'])->name('customFieldsDelete');
        Route::get('custom-field-change-status',[CustomFieldController::class,'status'])->name('customFieldsChangeStatus');
        Route::get('get-field-option',[CustomFieldController::class,'getFieldOption'])->name('getFieldOption');

        Route::get('category-custom-field-listing',[CategoryCustomFieldController::class,'index'])->name('categoryCustomFieldsListing');
        Route::get('create-category-custom-field',[CategoryCustomFieldController::class,'create'])->name('categoryCustomFieldsCreate');
        Route::post('save-category-custom-field',[CategoryCustomFieldController::class,'save'])->name('categoryCustomFieldsSave');
        Route::get('edit-category-custom-field/{id}',[CategoryCustomFieldController::class,'edit'])->name('categoryCustomFieldsEdit');
        Route::post('update-category-custom-field',[CategoryCustomFieldController::class,'update'])->name('categoryCustomFieldsUpdate');
        Route::post('delete-category-custom-field',[CategoryCustomFieldController::class,'delete'])->name('categoryCustomFieldsDelete');
        Route::get('category-custom-field-change-status',[CategoryCustomFieldController::class,'status'])->name('categoryCustomFieldsChangeStatus');
        Route::get('category-custom-field-change-position/{id}',[CategoryCustomFieldController::class,'changePosition'])->name('categoryCustomFieldsChangePosition');
        Route::post('category-custom-field-update-position',[CategoryCustomFieldController::class,'updatePosition'])->name('categoryCustomFieldsUpdatePosition');



        Route::get('product-listing',[ProductController::class,'index'])->name('productListing');
        Route::get('create-product',[ProductController::class,'create'])->name('productCreate');
        Route::post('save-product',[ProductController::class,'save'])->name('productSave');
        Route::get('edit-product/{id}',[ProductController::class,'edit'])->name('productEdit');
        Route::post('update-product',[ProductController::class,'update'])->name('productUpdate');
        Route::post('delete-product',[ProductController::class,'delete'])->name('productDelete');

        Route::get('category-brand',[BrandController::class,'getCategoryBrand'])->name('getCategoryBrand');
        Route::get('category-class',[ClassController::class,'getCategoryClass'])->name('getCategoryClass');
        Route::get('category-additional-option',[AdditionalOptionController::class,'getCategoryAdditionalOption'])->name('getCategoryAdditionalOption');
        Route::get('category-item-condition',[ItemConditionController::class,'getCategoryItemConditon'])->name('getCategoryItemConditon');
        Route::get('category-size',[SizeController::class,'getCategorySize'])->name('getCategorySize');
        Route::get('category-cloth-size',[ClothingTypeController::class,'getCategoryCloth'])->name('getCategoryCloth');

    });
});
