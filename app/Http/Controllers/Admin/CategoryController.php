<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(CategoryService $categoryService)
    {
        return $categoryService->index();
    }

    public function create(CategoryService $categoryService)
    {
        return $categoryService->create();
    }

    public function save(CategoryRequest $request,CategoryService $categoryService)
    {
        return $categoryService->save($request);
    }

    public function edit($id,CategoryService $categoryService)
    {
        return $categoryService->edit($id);
    }

    public function update(CategoryRequest $request,CategoryService $categoryService)
    {
        return $categoryService->update($request);
    }

    public function delete(Request $request,CategoryService $categoryService)
    {
        return $categoryService->delete($request);
    }

    public function status(Request $request,CategoryService $categoryService)
    {
        return $categoryService->changeStatus($request);
    }

}
