<?php


namespace App\Services\Api\Auth;


use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    public function register($request)
    {
        DB::beginTransaction();

        try {
            $user = User::create($request->except('password','country','city','city_lat','city_lng','country_lat',
                'country_lng') +
                ['password' => bcrypt($request->password), 'role_id' => 2]);

            $saveLocation =  UserLocation::create(['country'=>$request->country,
                'country_lat'=>$request->country_lat,'country_lng'=>$request->country_lng,
                'city'=>$request->city,
                'city_lat'=>$request->city_lat,'city_lng'=>$request->city_lng,'user_id'=>$user->id
            ]);

            $success['token'] = $user->createToken('ClassifiedMarketplace-' . rand(0, 9))->accessToken;

            $data = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'fcm_token' => $user->fcm_token
            ];

            DB::commit();
            return makeResponse("success", 'User Registered Successfully', 200, $data, $success['token']);


        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Creating User: ' . $e, 500);
        }
    }
}
