<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetCategoryFieldRequest;
use App\Services\Api\CategoryFieldService;
use App\Services\Api\CategoryFilterService;
use Illuminate\Http\Request;

class CategoryFieldController extends Controller
{
    public function getCategoryField(GetCategoryFieldRequest $request,CategoryFieldService $fieldService)
    {
        return $fieldService->getCategoryFields($request);
    }
}
