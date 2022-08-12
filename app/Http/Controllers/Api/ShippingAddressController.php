<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DeleteShippingAddressRequest;
use App\Http\Requests\Api\SaveShippingAddressRequest;
use App\Models\ShippingAddress;
use App\Services\Api\ShippingAddressService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{
    //

    public $shippingAddress;
    public function __construct(ShippingAddressService $shippingAddressService)
    {
        $this->shippingAddress = $shippingAddressService;
    }

    public function index()
    {
        return $this->shippingAddress->index();
    }

    public function save(SaveShippingAddressRequest $request)
    {
        $shippingAddress =  new ShippingAddress;
        return $this->shippingAddress->save($shippingAddress,$request);
    }

    public function update(SaveShippingAddressRequest $request)
    {
        $shippingAddress =  ShippingAddress::find($request->id);

        if($shippingAddress)
        {
            return $this->shippingAddress->save($shippingAddress,$request);
        }
        else{
            return makeResponse('error','Record Not Found',404);
        }


    }

    public function delete(DeleteShippingAddressRequest $request)
    {
        return $this->shippingAddress->delete($request);
    }

    public function defaultShippingAddress(DeleteShippingAddressRequest $request)
    {
        return $this->shippingAddress->makeDefault($request);
    }
}
