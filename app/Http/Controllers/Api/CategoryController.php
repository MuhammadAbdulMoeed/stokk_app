<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FetchSubCategoryRequest;
use App\Services\Api\CategoryService;
use App\Services\Api\HomeService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories(CategoryService $categoryService)
    {
        $categories = $categoryService->getAllCategories();

        return makeResponse('success', 'Category Retrieved Successfully', 200, $categories);
    }

    public function searchCategory(Request $request, CategoryService $categoryService)
    {
        return $categoryService->searchCategory($request);
    }

    public function getProduct(Request $request, CategoryService $categoryService)
    {
        return $categoryService->getProduct($request);
    }

    public function getSubCategory(FetchSubCategoryRequest $request, CategoryService $categoryService)
    {

        $subCategories = $categoryService->getSubCategory($request);

        if (sizeof($subCategories) > 0) {
            return makeResponse('success', 'SubCategory Retrieved Successfully', 200, $subCategories);
        } else {
            return makeResponse('error', 'Record Not Found', 200, $subCategories);
        }


    }
}
