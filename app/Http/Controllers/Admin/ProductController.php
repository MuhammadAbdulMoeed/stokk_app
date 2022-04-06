<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function save()
    {

    }

    public function edit($id)
    {

    }

    public function update()
    {

    }

    public function delete(Request $request)
    {

    }
}
