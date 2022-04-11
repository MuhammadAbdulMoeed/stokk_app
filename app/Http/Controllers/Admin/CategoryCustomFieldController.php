<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryCustomFieldRequest;
use App\Http\Requests\Admin\CategoryFilterRequest;
use App\Services\Admin\CategoryCustomFieldService;
use Illuminate\Http\Request;

class CategoryCustomFieldController extends Controller
{
    public function index(CategoryCustomFieldService $categoryCustomFieldService)
    {
        return $categoryCustomFieldService->index();
    }

    public function create(CategoryCustomFieldService $categoryCustomFieldService)
    {
        return $categoryCustomFieldService->create();
    }

    public function save(CategoryCustomFieldRequest $request, CategoryCustomFieldService $categoryCustomFieldService)
    {
        return $categoryCustomFieldService->save($request);
    }

    public function edit($id, CategoryCustomFieldService $categoryCustomFieldService)
    {
        return $categoryCustomFieldService->edit($id);
    }

    public function update(CategoryCustomFieldRequest $request, CategoryCustomFieldService $categoryCustomFieldService)
    {
        return $categoryCustomFieldService->update($request);
    }

    public function delete(Request $request, CategoryCustomFieldService $categoryCustomFieldService)
    {
        return $categoryCustomFieldService->delete($request);
    }

    public function status(Request $request, CategoryCustomFieldService $categoryCustomFieldService)
    {
        return $categoryCustomFieldService->changeStatus($request);
    }

    public function changePosition($id, CategoryCustomFieldService $categoryCustomFieldService)
    {
        return $categoryCustomFieldService->changePosition($id);
    }

    public function updatePosition(Request $request, CategoryCustomFieldService $categoryCustomFieldService)
    {
        return $categoryCustomFieldService->updatePosition($request);
    }
}
