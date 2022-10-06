<?php


namespace App\Services\Api;


use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Traits\SendFirebaseNotificationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    use SendFirebaseNotificationTrait;

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

            if ($getShippingAddress) {
                $order->shipping_address_id = $getShippingAddress;
            } else {
                return makeResponse('error', 'Default Shipping Address is Not Set', 500);
            }


            $order->save();

            $fcmToken =  $order->product->user->fcm_token;

            if($fcmToken)
            {
                $title = "Order Create Notification";
                $message = 'User: '.Auth::user()->first_name.' '.Auth::user()->last_name.' has placed an order on your product:  '.$order->product->name;

                $this->orderNotification($title,$message,$fcmToken);
            }

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

        if ($order) {
            $order->update(['order_status' => $request->order_status]);


            $fcmToken =  $order->user->fcm_token;

            if($fcmToken)
            {
                $title = "Order Notification";
                $message = 'Your Order: '.$order->product->name.' status has been changed to: '.$order->order_status;

                $this->orderNotification($title,$message,$fcmToken);
            }


            return makeResponse('success', 'Order Status Updated', 200);
        } else {
            return makeResponse('error', 'Record Not Found', 500);
        }
    }


    public function getNewOrder()
    {
        $getOwnOrders = Order::where('created_by', Auth::user()->id)
            ->where('order_status', 'pending')
            ->get();

        $myOrders = array();
        foreach ($getOwnOrders as $order) {
            $image = array();
            foreach ($order->product->productImages as $productImage) {
                $image[] = ['image' => $productImage->image];
            }


            $myOrders[] = ['product_name' => $order->product->name,
                'category_name' => $order->category->name,
                'sub_category_name' => $order->category->name,
                'price' => $order->price,
                'type' => $order->type,
                'price_type' => $order->price_type,
//                'order_detail' => json_decode($order->detail_json),
                'order_status' => $order->order_status,
                'images' => $image
            ];
        }


        $data = $myOrders;

        if (sizeof($data) > 0) {
            return makeResponse('success', 'Order List Fetch Successfully', 200, $data);
        } else {
            return makeResponse('success', 'Record Not Found', 404, $data);
        }


    }

    public function getActiveOrder()
    {
        $getOwnOrders = Order::where('created_by', Auth::user()->id)
            ->where('order_status', 'accept')
            ->get();

        $myOrders = array();
        foreach ($getOwnOrders as $order) {
            $image = array();
            foreach ($order->product->productImages as $productImage) {
                $image[] = ['image' => $productImage->image];
            }

            $myOrders[] = ['product_name' => $order->product->name,
                'category_name' => $order->category->name,
                'sub_category_name' => $order->category->name,
                'price' => $order->price,
                'type' => $order->type,
                'price_type' => $order->price_type,
//                'order_detail' => json_decode($order->detail_json),
                'order_status' => $order->order_status,
                'images' => $image

            ];
        }


        $data = $myOrders;


        if (sizeof($data) > 0) {
            return makeResponse('success', 'Order List Fetch Successfully', 200, $data);
        } else {
            return makeResponse('success', 'Record Not Found', 404, $data);
        }
    }

    public function getCompletedOrder()
    {
        $getOwnOrders = Order::where('created_by', Auth::user()->id)
            ->where('order_status', 'complete')
            ->get();

        $myOrders = array();
        foreach ($getOwnOrders as $order) {
            $image = array();
            foreach ($order->product->productImages as $productImage) {
                $image[] = ['image' => $productImage->image];
            }


            $myOrders[] = ['product_name' => $order->product->name,
                'category_name' => $order->category->name,
                'sub_category_name' => $order->category->name,
                'price' => $order->price,
                'type' => $order->type,
                'price_type' => $order->price_type,
//                'order_detail' => json_decode($order->detail_json),
                'order_status' => $order->order_status,
                'images' => $image
            ];
        }


        $data = $myOrders;


        if (sizeof($data) > 0) {
            return makeResponse('success', 'Order List Fetch Successfully', 200, $data);
        } else {
            return makeResponse('success', 'Record Not Found', 200, $data);
        }
    }


    public function getNewOrderForApproval()
    {


        $getUserProductOrder = Product::where('created_by', Auth::user()->id)->pluck('id')
            ->toArray();

        $getPendingProductOrders = Order::whereIn('product_id', $getUserProductOrder)
            ->where('created_by', '!=', Auth::user()->id)
            ->where('order_status', 'pending')
            ->get();

        $pendingOrders = array();

        foreach ($getPendingProductOrders as $orderRequest) {
            $image = array();
            foreach ($orderRequest->product->productImages as $productImage) {
                $image[] = ['image' => $productImage->image];
            }

            $pendingOrders[] = ['product_name' => $orderRequest->product->name,
                'category_name' => $orderRequest->category->name,
                'sub_category_name' => $orderRequest->category->name,
                'price' => $orderRequest->price,
                'type' => $orderRequest->type,
                'price_type' => $orderRequest->price_type,
//                'order_detail' => json_decode($orderRequest->detail_json),
                'order_status' => $orderRequest->order_status,
                'images' => $image,
                'product_id' => $orderRequest->product_id
            ];
        }

        $data = $pendingOrders;


        if (sizeof($data) > 0) {
            return makeResponse('success', 'Order List Fetch Successfully', 200, $data);
        } else {
            return makeResponse('success', 'Record Not Found', 200, $data);
        }
    }

    public function getActiveOrderForApproval()
    {


        $getUserProductOrder = Product::where('created_by', Auth::user()->id)->pluck('id')
            ->toArray();

        $getAcceptedProductOrders = Order::whereIn('product_id', $getUserProductOrder)
            ->where('created_by', '!=', Auth::user()->id)
            ->where('order_status', 'accept')
            ->get();

        $acceptOrders = array();

        foreach ($getAcceptedProductOrders as $orderRequest) {
            $image = array();
            foreach ($orderRequest->product->productImages as $productImage) {
                $image[] = ['image' => $productImage->image];
            }

            $acceptOrders[] = ['product_name' => $orderRequest->product->name,
                'category_name' => $orderRequest->category->name,
                'sub_category_name' => $orderRequest->category->name,
                'price' => $orderRequest->price,
                'type' => $orderRequest->type,
                'price_type' => $orderRequest->price_type,
//                'order_detail' => json_decode($orderRequest->detail_json),
                'order_status' => $orderRequest->order_status,
                'images' => $image,
                'product_id' => $orderRequest->product_id
            ];
        }

        $data = $acceptOrders;

        if (sizeof($data) > 0) {
            return makeResponse('success', 'Order List Fetch Successfully', 200, $data);
        } else {
            return makeResponse('success', 'Record Not Found', 200, $data);
        }
    }

    public function getCompletedOrderForApproval()
    {


        $getUserProductOrder = Product::where('created_by', Auth::user()->id)->pluck('id')
            ->toArray();

        $getAcceptedProductOrders = Order::whereIn('product_id', $getUserProductOrder)
            ->where('created_by', '!=', Auth::user()->id)
            ->where('order_status', 'complete')
            ->get();

        $completeOrders = array();

        foreach ($getAcceptedProductOrders as $orderRequest) {

            $image = array();
            foreach ($orderRequest->product->productImages as $productImage) {
                $image[] = ['image' => $productImage->image];
            }

            $completeOrders[] = ['product_name' => $orderRequest->product->name,
                'category_name' => $orderRequest->category->name,
                'sub_category_name' => $orderRequest->category->name,
                'price' => $orderRequest->price,
                'type' => $orderRequest->type,
                'price_type' => $orderRequest->price_type,
//                'order_detail' => json_decode($orderRequest->detail_json),
                'order_status' => $orderRequest->order_status,
                'images' => $image,
                'product_id' => $orderRequest->product_id
            ];
        }

        $data = $completeOrders;

        if (sizeof($data) > 0) {
            return makeResponse('success', 'Order List Fetch Successfully', 200, $data);
        } else {
            return makeResponse('success', 'Record Not Found', 200, $data);
        }
    }


}

