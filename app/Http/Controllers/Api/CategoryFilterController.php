<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetCategoryFilterRequest;
use App\Services\Api\CategoryFilterService;
use Illuminate\Http\Request;

class CategoryFilterController extends Controller
{

    public function getCategoryFilter(GetCategoryFilterRequest $request,CategoryFilterService $filterService)
    {
        return $filterService->getCategoryFilter($request);
    }

}
