<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\CategoryFilterService;
use Illuminate\Http\Request;

class CategoryFilterController extends Controller
{

    public function getCategoryFilter(Request $request,CategoryFilterService $filterService)
    {
        return $filterService->getCategoryFilter($request);
    }

}
