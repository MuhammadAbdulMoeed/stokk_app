<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(HomeService $homeService)
    {
        $categories = $homeService->getAllCategories();

        $products = $homeService->getNearbyProduct();

        $data = ['products'=>$products,'categories'=>$categories];

        return makeResponse('success','',200,$data);
    }

    public function searchProduct(Request $request,HomeService $homeService)
    {
        return $homeService->searchProduct($request);
    }

}
