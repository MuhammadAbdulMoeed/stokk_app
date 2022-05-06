<?php


namespace App\Traits;


use Illuminate\Support\Facades\Auth;

trait ProductFetchTrait
{
    public function fetchProduct($productsList)
    {
        $products = array();

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

        return $products;
    }
}
