<?php


namespace App\Services\Api;


use App\Models\Product;
use App\Traits\ProductFetchTrait;
use Illuminate\Support\Facades\Auth;

class MyProductService
{

    use ProductFetchTrait;

    public function myProduct()
    {
        $productsList = Product::where('is_active', 1)->where('created_by', Auth::user()->id)->get();
        if (sizeof($productsList) > 0) {

            $products = $this->fetchProduct($productsList);

            return makeResponse('success', 'Product Found', 200,$products);
        } else {
            return makeResponse('error', 'No Record Found', 404);
        }

    }
}
