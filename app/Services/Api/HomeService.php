<?php


namespace App\Services\Api;


use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeService
{
    public function getAllCategories()
    {
        $categories = Category::select('id','name','icon')->where('is_active',1)->whereNull('parent_id')->get();

        return $categories;
    }

    public function getNearbyProduct()
    {

        $data = Product::where('city',Auth::user()->userLocation->city)
            ->where('is_active',1)->inRandomOrder()
            ->limit(8)->get();

        $products = array();
        $productImage =  array();

        foreach($data as $key => $product)
        {

            $status = 'no';
            $isFavorite = $product->isFavorite->where('user_id',Auth::user()->id)->first();

            if($isFavorite)
            {
                $status =  'yes';
            }

            foreach($product->productImages as $image)
            {
                $productImage[] =  $image->image;
            }

            $products[] = ['name'=>$product->name,'id'=>$product->id,'images'=>$productImage,
                'totalFavorite'=>count($product->isFavorite),'is_favorite'=>$status];
        }

        return $products;
    }

    public function searchProduct($request)
    {
        $data = Product::where('name','like','%' . $request->name . '%')
            ->get();

        $products = array();
        $productImage =  array();

        if(sizeof($data) > 0)
        {
            foreach($data as $key => $product)
            {

                $status = 'no';
                $isFavorite = $product->isFavorite->where('user_id',Auth::user()->id)->first();

                if($isFavorite)
                {
                    $status =  'yes';
                }

                foreach($product->productImages as $image)
                {
                    $productImage[] =  $image->image;
                }

                $products[] = ['name'=>$product->name,'id'=>$product->id,'images'=>$productImage,
                    'totalFavorite'=>count($product->isFavorite),'is_favorite'=>$status];
            }

            return makeResponse('success','Product Found Successfully',200,$products);
        }
        else{
            return makeResponse('error','Record Not Found',200);
        }


    }
}
