<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\MyProductService;
use Illuminate\Http\Request;

class MyProductController extends Controller
{
    public function myProduct(MyProductService $productService)
    {
        return $productService->myProduct();
    }
}
