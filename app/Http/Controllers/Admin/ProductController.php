<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductSaveRequest;
use App\Http\Requests\Admin\ProfileSaveRequest;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(ProductService $productService)
    {
        return $productService->index();
    }

    public function create(ProductService $productService)
    {
        return $productService->create();
    }

    public function save(ProductSaveRequest $request,ProductService $productService)
    {

        return $productService->save($request);
    }

    public function edit($id,ProductService $productService)
    {
        return $productService->edit($id);
    }

    public function update()
    {

    }

    public function delete(Request $request)
    {

    }
}
