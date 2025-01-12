<?php


namespace App\Services\Api;


use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShippingAddressService
{
    public function index()
    {
        $shippingAddress = $this->getShippingAddress();


        if (sizeof($shippingAddress) > 0) {
            return makeResponse('success', 'Shipping Address Found', 200, $shippingAddress);
        } else {
            return makeResponse('error', 'Record Not Found', 404);
        }
    }

    public function save($shippingAddress, $request)
    {
        try {
            $shippingAddress->address = $request->address;
            $shippingAddress->latitude = $request->latitude;
            $shippingAddress->longitude = $request->longitude;
            $shippingAddress->user_id = Auth::user()->id;

            $shippingAddress->save();

            $data = $this->getShippingAddress();

            return makeResponse('success', 'Record Save Successfully', 200, $data);


        } catch (\Exception $e) {
            return makeResponse('error', 'Error in Saving Shipping Address: ' . $e, 500);
        }


    }


    public function delete($request)
    {
        $data = ShippingAddress::find($request->id);

        if ($data) {
            if ($data->user_id != Auth::user()->id) {
                return makeResponse('error', 'Invalid Record', 401);
            }

            try {
                $data->delete();

                $data = $this->getShippingAddress();

                return makeResponse('success', 'Shipping Address Deleted Successfully', 200, $data);
            } catch (\Exception $e) {
                return makeResponse('error', 'Error in Deleting Address: ' . $e, 500);
            }

        } else {
            return makeResponse('error', 'Record Not Found', 404);
        }
    }

    public function getShippingAddress()
    {
        $data = ShippingAddress::where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();

        $shippingAddress = array();
        foreach ($data as $address) {
            if (Auth::user()->default_shipping_address == $address->id) {
                $shippingAddress[] = ['id' => $address->id, 'latitude' => $address->latitude,
                    'longitude' => $address->longitude, 'address' => $address->address, 'default' => 1];
            } else {
                $shippingAddress[] = ['id' => $address->id, 'latitude' => $address->latitude,
                    'longitude' => $address->longitude, 'address' => $address->address, 'default' => 0];
            }

        }

        return $shippingAddress;

    }

    public function makeDefault($request)
    {
        DB::beginTransaction();
        $data = ShippingAddress::find($request->id);

        if ($data) {
            if ($data->user_id != Auth::user()->id) {
                return makeResponse('error', 'Invalid Record', 401);
            }

            try {

                Auth::user()->default_shipping_address = $data->id;
//                $data->user->default_shipping_address = $data->id;

//                $data->user->save();
                Auth::user()->save();
                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                return makeResponse('error', 'Error in Making Shipping Address Default: ' . $e, 500);
            }


            $shippingAddress = $this->getShippingAddress();
            return makeResponse('success', 'Shipping Address Set As Default', 200, $shippingAddress);

        } else {
            DB::rollBack();
            return makeResponse('error', 'Record Not Found', 404);
        }
    }

    public function getDefaultShippingAddress()
    {
        $data = ShippingAddress::where('user_id', Auth::user()->id)
            ->where('id', Auth::user()->default_shipping_address)->first();

        $shippingAddress = array();
        if ($data) {
            $shippingAddress = ['id' => $data->id,
                'latitude' => $data->latitude, 'longitude' => $data->longitude,
                'address' => $data->address, 'default' => 1];
        }

        if (sizeof($shippingAddress) > 0) {
            return makeResponse('success', 'Default Address Fetch Successfully', 200, (object)$shippingAddress);
        } else {
            return makeResponse('error', 'Record Not Found', 404);

        }


    }
}
