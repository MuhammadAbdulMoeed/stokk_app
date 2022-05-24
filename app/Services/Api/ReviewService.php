<?php


namespace App\Services\Api;


use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    public function save($request)
    {
        DB::beginTransaction();
        try {

            $check = ProductReview::where('product_id',$request->product_id)
                ->where('user_id',Auth::user()->id)->first();

            if($check)
            {
                DB::rollBack();
                return makeResponse('error', 'You have already given Review to this Product' , 401);
            }

            ProductReview::create(['product_id' => $request->product_id,
                'user_id' => Auth::user()->id,
                'rating' => $request->rating
            ]);

            DB::commit();
            return makeResponse('success', 'Review Save Successfully', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Saving Review: ' . $e, 500);
        }
    }
}
