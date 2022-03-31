<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryFilterRequest;
use App\Services\Admin\CategoryFilterService;
use Illuminate\Http\Request;

class CategoryFilterController extends Controller
{
    public function index(CategoryFilterService $filterService)
    {
        return $filterService->index();
    }

    public function create(CategoryFilterService $filterService)
    {
        return $filterService->create();
    }

    public function save(CategoryFilterRequest $request, CategoryFilterService $filterService)
    {
        return $filterService->save($request);
    }

    public function edit($id, CategoryFilterService $filterService)
    {
        return $filterService->edit($id);
    }

    public function update(CategoryFilterRequest $request, CategoryFilterService $filterService)
    {
        return $filterService->update($request);
    }

    public function delete(Request $request, CategoryFilterService $filterService)
    {
        return $filterService->delete($request);
    }

    public function status(Request $request, CategoryFilterService $filterService)
    {
        return $filterService->changeStatus($request);
    }
}
