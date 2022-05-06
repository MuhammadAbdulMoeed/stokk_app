<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\HomeService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories(HomeService $homeService)
    {
        $categories =  $homeService->getAllCategories();

        return makeResponse('success','Category Retrieved Successfully',200,$categories);
    }

    public function searchCategory(Request $request,HomeService $homeService)
    {
        return $homeService->searchCategory($request);
    }

    public function getSubCategoryProduct(Request $request,HomeService $homeService)
    {
        return $homeService->getSubCategoryProduct($request);
    }
}
