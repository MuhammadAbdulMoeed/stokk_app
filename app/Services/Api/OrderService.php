<?php


namespace App\Services\Api;


use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingAddress;
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

//            $order->detail_json = json_encode($request->except('product_id', 'category_id', 'sub_category_id',
//                'price', 'type', 'price_type'));
            $order->created_by = Auth::user()->id;

            $getShippingAddress = Auth::user()->default_shipping_address;

            if($getShippingAddress)
            {
                $order->shipping_address_id =  $getShippingAddress;
            }
            else{
                return makeResponse('error','Default Shipping Address is Not Set',500);
            }


            $order->save();

            DB::commit();
            return makeResponse('success', 'Order Save Successfully', 200, (object)$order);

        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Creating Order: ' . $e, 500);
        }
    }


    public function changeStatus($request)
    {
        $order = Order::find($request->order_id);

        if($order)
        {
            $order->update(['order_status'=>$request->order_status]);
            return makeResponse('success','Order Status Updated',200);
        }
        else{
            return makeResponse('error','Record Not Found',500);
        }
    }


    public function getNewOrder()
    {
        $getOwnOrders = Order::where('created_by', Auth::user()->id)
            ->where('order_status','pending')
            ->get();

        $myOrders = array();
        foreach ($getOwnOrders as $order) {
            $myOrders[] = ['product_name' => $order->product->name,
                'category_name' => $order->category->name,
                'sub_category_name' => $order->category->name,
                'price' => $order->price,
                'type' => $order->type,
                'price_type' => $order->price_type,
//                'order_detail' => json_decode($order->detail_json),
                'order_status' => $order->order_status,
            ];
        }


        $data = $myOrders;

        if(sizeof($data) > 0)
        {
            return makeResponse('success','Order List Fetch Successfully',200,$data);
        }
        else{
            return makeResponse('success','Record Not Found',404,$data);
        }



    }

    public function getActiveOrder()
    {
        $getOwnOrders = Order::where('created_by', Auth::user()->id)
            ->where('order_status','accept')
            ->get();

        $myOrders = array();
        foreach ($getOwnOrders as $order) {
            $myOrders[] = ['product_name' => $order->product->name,
                'category_name' => $order->category->name,
                'sub_category_name' => $order->category->name,
                'price' => $order->price,
                'type' => $order->type,
                'price_type' => $order->price_type,
//                'order_detail' => json_decode($order->detail_json),
                'order_status' => $order->order_status,
            ];
        }


        $data = $myOrders;


        if(sizeof($data) > 0)
        {
            return makeResponse('success','Order List Fetch Successfully',200,$data);
        }
        else{
            return makeResponse('success','Record Not Found',404,$data);
        }
    }

    public function getCompletedOrder()
    {
        $getOwnOrders = Order::where('created_by', Auth::user()->id)
            ->where('order_status','complete')
            ->get();

        $myOrders = array();
        foreach ($getOwnOrders as $order) {
            $myOrders[] = ['product_name' => $order->product->name,
                'category_name' => $order->category->name,
                'sub_category_name' => $order->category->name,
                'price' => $order->price,
                'type' => $order->type,
                'price_type' => $order->price_type,
//                'order_detail' => json_decode($order->detail_json),
                'order_status' => $order->order_status,
            ];
        }



        $data =   $myOrders;


        if(sizeof($data) > 0)
        {
            return makeResponse('success','Order List Fetch Successfully',200,$data);
        }
        else{
            return makeResponse('success','Record Not Found',200,$data);
        }
    }


    public function getNewOrderForApproval()
    {


        $getUserProductOrder = Product::where('created_by', Auth::user()->id)->pluck('id')
            ->toArray();

        $getPendingProductOrders =  Order::whereIn('product_id',$getUserProductOrder)
            ->where('created_by','!=',Auth::user()->id)
            ->where('order_status','pending')
            ->get();

        $pendingOrders = array();

        foreach($getPendingProductOrders as $orderRequest)
        {
            $pendingOrders[] = ['product_name' => $orderRequest->product->name,
                'category_name' => $orderRequest->category->name,
                'sub_category_name' => $orderRequest->category->name,
                'price' => $orderRequest->price,
                'type' => $orderRequest->type,
                'price_type' => $orderRequest->price_type,
//                'order_detail' => json_decode($orderRequest->detail_json),
                'order_status' => $orderRequest->order_status,
            ];
        }

        $data = $pendingOrders;


        if(sizeof($data) > 0)
        {
            return makeResponse('success','Order List Fetch Successfully',200,$data);
        }
        else{
            return makeResponse('success','Record Not Found',200,$data);
        }
    }

    public function getActiveOrderForApproval()
    {


        $getUserProductOrder = Product::where('created_by', Auth::user()->id)->pluck('id')
            ->toArray();

        $getAcceptedProductOrders =  Order::whereIn('product_id',$getUserProductOrder)
            ->where('created_by','!=',Auth::user()->id)
            ->where('order_status','accept')
            ->get();

        $acceptOrders = array();

        foreach($getAcceptedProductOrders as $orderRequest)
        {
            $acceptOrders[] = ['product_name' => $orderRequest->product->name,
                'category_name' => $orderRequest->category->name,
                'sub_category_name' => $orderRequest->category->name,
                'price' => $orderRequest->price,
                'type' => $orderRequest->type,
                'price_type' => $orderRequest->price_type,
//                'order_detail' => json_decode($orderRequest->detail_json),
                'order_status' => $orderRequest->order_status,
            ];
        }

        $data = $acceptOrders;

        if(sizeof($data) > 0)
        {
            return makeResponse('success','Order List Fetch Successfully',200,$data);
        }
        else{
            return makeResponse('success','Record Not Found',200,$data);
        }
    }

    public function getCompletedOrderForApproval()
    {


        $getUserProductOrder = Product::where('created_by', Auth::user()->id)->pluck('id')
            ->toArray();

        $getAcceptedProductOrders =  Order::whereIn('product_id',[$getUserProductOrder])
            ->where('created_by','!=',Auth::user()->id)
            ->where('order_status','complete')
            ->get();

        $completeOrders = array();

        foreach($getAcceptedProductOrders as $orderRequest)
        {
            $completeOrders[] = ['product_name' => $orderRequest->product->name,
                'category_name' => $orderRequest->category->name,
                'sub_category_name' => $orderRequest->category->name,
                'price' => $orderRequest->price,
                'type' => $orderRequest->type,
                'price_type' => $orderRequest->price_type,
//                'order_detail' => json_decode($orderRequest->detail_json),
                'order_status' => $orderRequest->order_status,
            ];
        }

        $data = $completeOrders;

        if(sizeof($data) > 0)
        {
            return makeResponse('success','Order List Fetch Successfully',200,$data);
        }
        else{
            return makeResponse('success','Record Not Found',200,$data);
        }
    }



}

