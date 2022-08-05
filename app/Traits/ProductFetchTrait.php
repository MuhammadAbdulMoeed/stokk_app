<?php


namespace App\Traits;


use App\Models\ProductReview;
use Carbon\Carbon;
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
                'totalFavorite' => count($product->isFavorite), 'is_favorite' => $status,
                'product_type' => $product->type,
                'price' => $product->type == 'for_sale' ? $product->price : null,
                'description' => $product->description, 'location' => $product->location,
                'monthly_price' => $product->type == 'for_rent' ? $product->per_month_rent_price : null,
                'daily_price' => $product->type == 'for_rent' ? $product->per_day_rent_price : null,
                'hourly_price' => $product->type == 'for_rent' ? $product->per_hour_rent_price : null,
                'product_creator_id' => $product->created_by,
                'product_created_ago' => Carbon::parse($product->created_at)->diffForHumans(),
                'avg_rating' => number_format(ProductReview::where('product_id', $product->id)->avg('rating'), '2', '.', ',')

            ];
        }

        return $products;
    }

    public function fetchSingleProduct($product)
    {
        $productImage = [];
        $status = 'no';
        $isFavorite = $product->isFavorite->where('user_id', Auth::user()->id)->first();

        if ($isFavorite) {
            $status = 'yes';
        }

        foreach ($product->productImages as $image) {
            $productImage[] = $image->image;
        }

        $products = ['name' => $product->name, 'id' => $product->id, 'images' => $productImage,
            'totalFavorite' => count($product->isFavorite), 'is_favorite' => $status,
            'product_type' => $product->type,
            'price' => $product->type == 'for_sale' ? $product->price : null,
            'description' => $product->description, 'location' => $product->location,
            'monthly_price' => $product->type == 'for_rent' ? $product->per_month_rent_price : null,
            'daily_price' => $product->type == 'for_rent' ? $product->per_day_rent_price : null,
            'hourly_price' => $product->type == 'for_rent' ? $product->per_hour_rent_price : null,
            'product_creator_id' => $product->created_by,
            'product_created_ago' => Carbon::parse($product->created_at)->diffForHumans(),
            'checkout_type' => $product->category->checkout_type,
            'avg_rating' => number_format(ProductReview::where('product_id', $product->id)->avg('rating'), '2', '.', ',')

        ];

        return $products;
    }

}
