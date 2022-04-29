<?php


namespace App\Services\Api;


use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteService
{
    public function favoriteProduct($request)
    {
        DB::beginTransaction();
        $favorite = Favorite::where('product_id', $request->product_id)->where('user_id', Auth::user()->id)->first();

        try {
            $message = null;
            $data = array();
            if ($favorite) {
                $favorite->delete();
                $message = 'Product is removed from your Favorite Product';
                $data = ['is_favorite' => 'no', 'product_id' => $request->product_id];
            } else {
                Favorite::create(['product_id' => $request->product_id, 'user_id' => Auth::user()->id]);
                $message = 'Added  in Your Favorite Product';
                $data = ['is_favorite' => 'yes', 'product_id' => $request->product_id];
            }

            DB::commit();
            return makeResponse('success', $message,200,$data);
        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Favorite Product: ' .$e, 500);
        }

    }


}
