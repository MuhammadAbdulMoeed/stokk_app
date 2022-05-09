<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductSaveRequest;
use App\Services\Api\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function save(ProductSaveRequest $request,ProductService $productService)
    {
        return $productService->save($request);
    }
}
