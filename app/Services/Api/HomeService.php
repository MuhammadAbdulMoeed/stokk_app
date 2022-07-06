<?php


namespace App\Services\Api;


use App\Models\Category;
use App\Models\Product;
use App\Traits\ProductFetchTrait;
use Illuminate\Support\Facades\Auth;

class HomeService
{
    use ProductFetchTrait;

    public function getNearbyProduct()
    {
        $data = Product::where('is_active', 1)->where('created_by',Auth::user()->id)
            ->inRandomOrder()
            ->limit(8);

//        if (isset(Auth::user()->userLocation->city)) {
//            $data = $data->where('city', Auth::user()->userLocation->city)->get();
//        } else {
            $data = $data->get();
//        }

        $products = array();
        $productImage = array();

        $products = $this->fetchProduct($data);


        return $products;
    }

    public function searchProduct($request)
    {
        $data = Product::where('is_active', 1);

        if($request->has('name'))
        {
            $data = $data->where('name', 'like', '%' . $request->name . '%');
        }

        if($request->has('category_id'))
        {
            $data = $data->where('category_id',$request->category_id);
        }

        if($request->has('sub_category_id'))
        {
            $data =  $data->where('sub_category_id',$request->sub_category_id);
        }

        $data = $data->get();


        $products = array();
        $productImage = array();

        if (sizeof($data) > 0) {

            $products = $this->fetchProduct($data);

            return makeResponse('success', 'Product Found Successfully', 200, $products);
        } else {
            return makeResponse('error', 'Record Not Found', 404);
        }
    }


}
