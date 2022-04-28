<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\CategoryFieldService;
use App\Services\Api\CategoryFilterService;
use Illuminate\Http\Request;

class CategoryFieldController extends Controller
{
    public function getCategoryField(Request $request,CategoryFieldService $fieldService)
    {
        return $fieldService->getCategoryFields($request);
    }
}
