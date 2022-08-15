<?php


namespace App\Services\Api;


use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function create($request)
    {
        DB::beginTransaction();
        try {

            $order = new Order;

            $order->product_id = $request->product_id;
            $order->category_id = $request->category_id;
            $order->sub_category_id = $request->sub_category_id;
            $order->price = $request->price;
            $order->type = $request->type;

            if ($request->price_type) {
                $order->price_type = $request->price_type;
            }

            $order->detail_json = json_encode($request->except('_product_id', 'category_id', 'sub_category_id',
                'price', 'type', 'price_type'));
            $order->created_by = Auth::user()->id;

            $order->save();

            DB::commit();
            return makeResponse('success', 'Order Save Successfully', 200, (object)$order);

        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Creating Order: ' . $e, 500);
        }
    }

    public function getPendingOrder()
    {
        $getOwnOrders = Order::where('created_by', Auth::user()->id)
//            ->where('order_status','pending')
            ->get();

        $myOrders = array();
        foreach ($getOwnOrders as $order) {
            $myOrders[] = ['product_name' => $order->product->name,
                'category_name' => $order->category->name,
                'sub_category_name' => $order->category->name,
                'price' => $order->price,
                'type' => $order->type,
                'price_type' => $order->price_type,
                'order_detail' => json_decode($order->detail_json),
                'order_status' => $order->order_status,
            ];
        }

        $getAcceptedOrder = Product::where('created_by', Auth::user()->id)->pluck('id')
            ->toArray();

        $getPendingProductOrders =  Order::whereIn('product_id',[$getAcceptedOrder])
            ->where('created_by','!=',Auth::user()->id)
//            ->where('order_status','pending')
            ->get();

        $orderForRequest = array();

        foreach($orderForRequest as $orderRequest)
        {
            $pendingOrders[] = ['product_name' => $orderRequest->product->name,
                'category_name' => $orderRequest->category->name,
                'sub_category_name' => $orderRequest->category->name,
                'price' => $orderRequest->price,
                'type' => $orderRequest->type,
                'price_type' => $orderRequest->price_type,
                'order_detail' => json_decode($orderRequest->detail_json),
                'order_status' => $orderRequest->order_status,
            ];
        }

        $data = [
            'myOrder' =>  $myOrders,
            'orderForApproval' => $orderForRequest
        ];

        return makeResponse('success','Order List Fetch Successfully',200,$data);



    }
}
