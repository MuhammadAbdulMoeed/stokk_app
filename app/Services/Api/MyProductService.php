<?php


namespace App\Services\Api;


use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MyProductService
{
    public function myProduct()
    {
        $productsList = Product::where('is_active', 1)->where('created_by', Auth::user()->id)->get();
        if (sizeof($productsList) > 0) {
            foreach ($productsList as $product) {
                $productImage = [];
                $status = 'no';
                $isFavorite = $product->isFavorite->where('user_id', Auth::user()->id)->first();

                if ($isFavorite) {
                    $status = 'yes';
                }

                foreach ($product->productImages as $image) {
                    $productImage[] = $image->image;
                }

                $products[] = ['name' => $product->name, 'id' => $product->id, 'images' => $productImage,
                    'totalFavorite' => count($product->isFavorite), 'is_favorite' => $status];
            }

            return makeResponse('success', 'Product Found', 200,$products);
        } else {
            return makeResponse('success', 'No Record Found', 200);
        }

    }
}
