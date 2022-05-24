<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FavoriteRequest;
use App\Services\Api\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function favoriteProduct(FavoriteRequest $request, FavoriteService $favoriteService)
    {
        return $favoriteService->favoriteProduct($request);
    }

    public function favoriteProductList(Request $request,FavoriteService $favoriteService)
    {
        return $favoriteService->favoriteProductList($request);
    }
}
