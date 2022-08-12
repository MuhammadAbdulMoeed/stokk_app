<?php


namespace App\Services\Api\Auth;


use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    public function register($request)
    {
        DB::beginTransaction();

        try {
            $user = User::create($request->except('password') +
                ['password' => bcrypt($request->password), 'role_id' => 2]);


            $success['token'] = $user->createToken('ClassifiedMarketplace-' . rand(0, 9))->accessToken;


            $data = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'fcm_token' => $user->fcm_token,
                'is_completed' => 0,
                'provider' => $user->provider,
                'city' => null,
                'country' => null,
                'lat' =>  null,
                'lng' =>  null,
                'profile_image' => $user->profile_image,
                'user_id' => $user->id,
                'location' => null,
//                'default_shipping_address' => null

            ];

            DB::commit();
            return makeResponse("success", 'User Registered Successfully', 200, $data, $success['token']);


        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Creating User: ' . $e, 500);
        }
    }
}
