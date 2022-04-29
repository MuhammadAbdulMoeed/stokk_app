<?php


namespace App\Services\Api;


use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeService
{
    public function getAllCategories()
    {
        $categories = Category::select('id','name','icon','image')->where('is_active',1)->whereNull('parent_id')->get();

        return $categories;
    }

    public function getNearbyProduct()
    {
        $data = Product::where('is_active',1)->inRandomOrder()
            ->limit(8);

        if(isset(Auth::user()->userLocation->city))
        {
            $data = $data->where('city',Auth::user()->userLocation->city)->get();
        }
        else{
            $data = $data->get();
        }

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
            ->where('is_active',1)
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

    public function searchCategory($request)
    {
        $data = Category::where('name','like','%' . $request->name . '%')
            ->whereNull('parent_id')
            ->where('is_active',1)
            ->get();

        $categories = array();

        if(sizeof($data) > 0)
        {
            foreach($data as $key => $category)
            {
                $categories[] = ['name'=>$category->name,'id'=>$category->id,'images'=>$category->image,
                    'icon'=>$category->icon];
            }

            return makeResponse('success','Category Found Successfully',200,$categories);
        }
        else{
            return makeResponse('error','Record Not Found',200);
        }
    }
}
