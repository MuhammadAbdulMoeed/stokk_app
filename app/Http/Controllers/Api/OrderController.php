<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangeOrderStatus;
use App\Http\Requests\Api\CreateOrderRequest;
use App\Services\Api\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    //
    public function create(CreateOrderRequest $request)
    {
        return $this->orderService->create($request);
    }

    public function getPendingOrder()
    {
        return $this->orderService->getPendingOrder();
    }

    public function changeStatus(ChangeOrderStatus $request)
    {
        return $this->orderService->changeStatus($request);
    }
}
