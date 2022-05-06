<?php


namespace App\Services\Api;


use App\Models\UserLocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserLocationService
{
    public function save($request)
    {
        DB::beginTransaction();
        try {
            if(Auth::user()->userLocation) {
                $saveLocation = Auth::user()->userLocation;
            }
            else{
                $saveLocation =  new UserLocation;

            }

            $saveLocation->country = $request->country;
            $saveLocation->city = $request->city;
            $saveLocation->lat = $request->lat;
            $saveLocation->lng = $request->lng;
            $saveLocation->user_id = Auth::user()->id;

            $saveLocation->save();

            $data = [
                'country' => $saveLocation->country,
                'city' => $saveLocation->city,
                'lat' => $saveLocation->lat, 'lng' => $saveLocation->lng
            ];

            DB::commit();
            return makeResponse('success', 'User Location Save Successfully', 200,$data);

        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Saving User Location: ', $e, '422');
        }
    }
}
