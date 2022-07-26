<?php


namespace App\Services\Api\Auth;


use App\Helper\ImageUploadHelper;
use App\Models\User;
use App\Models\UserLocation;
use Egulias\EmailValidator\Exception\AtextAfterCFWS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginService
{
    public function loginWithEmail($request)
    {
        DB::beginTransaction();
        try {
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

                Auth::user()->fcm_token = $request->fcm_token;

                Auth::user()->save();

                if(Auth::user()->uuid != null && Auth::user()->provider != null)
                {
                    DB::rollBack();
                    return makeResponse('error', 'Invalid Credentials', 401);
                }

                $token = Auth::user()->createToken('ClassifiedMarketplace-' . rand(0, 9))->accessToken;

                $data = [
                    'first_name' => Auth::user()->first_name,
                    'last_name' => Auth::user()->last_name,
                    'email' => Auth::user()->email,
                    'fcm_token' => Auth::user()->fcm_token,
                    'is_completed' => Auth::user()->userLocation ? 1:0,
                    'provider' => Auth::user()->provider,
                    'city' => Auth::user()->userLocation ? Auth::user()->userLocation->city: null,
                    'country' => Auth::user()->userLocation ? Auth::user()->userLocation->country: null,
                    'lat' => Auth::user()->userLocation ? Auth::user()->userLocation->lat: null,
                    'lng' => Auth::user()->userLocation ? Auth::user()->userLocation->lng: null,
                    'profile_image' => Auth::user()->profile_image,
                    'user_id' => Auth::user()->id
                ];

                DB::commit();
                return makeResponse('success', 'Login Successfully', 200, $data, $token);
            } else {
                DB::rollBack();
                return makeResponse('error', 'Invalid Credentials', 401);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Server Error During Login: ' . $e, 500);

        }
    }

    public function socialLogin($request)
    {
        DB::beginTransaction();
        try {
            $message = '';
            $user = User::where('uuid', $request->uuid)
                ->where('provider', $request->provider)->first();

            if ($user) {

                $name = explode(' ',$request->full_name);
                $user->first_name = isset($name[0]) ? $name[0] : null;
                $user->last_name = isset($name[1]) ? $name[1] : null;
                $user->email = isset($request->email) ? $request->email : null;
                $user->uuid = $request->uuid;
                $user->provider = $request->provider;
                $user->fcm_token  = $request->fcm_token;
                $user->save();

                $message = "Login Successfully";
            }
            else {
                $checkEmail = User::where('email', $request->email)->first();
                if($checkEmail)
                {
                    DB::rollBack();
                    return makeResponse('error', 'Email Already Exist', 401);
                }
                if ($request->provider == 'FACEBOOK') {
                    $user = $this->loginWithFb($request);
                } elseif ($request->provider == 'APPLE') {
                    $user = $this->loginWithApple($request);
                } elseif ($request->provider == 'GMAIL') {
                    $user = $this->loginWithGmail($request);
                }

                if($request->has('profile_image'))
                {
                    $fileContents = file_get_contents($request->profile_image);
                    $fileNameUpload = time() . "-" .'.jpg';
                    $drive = 'upload/user/';

                    $imageSave = ImageUploadHelper::saveImage($fileContents, $fileNameUpload, $drive);
                    $user->profile_image= $imageSave;

                    $user->save();
                }

                $message = 'User Registered Successfully';


            }


            Auth::loginUsingId($user->id);
            $token = Auth::user()->createToken('ClassifiedMarketplace-' . rand(0, 9))->accessToken;

            $data = [
                'first_name' => Auth::user()->first_name,
                'last_name' => Auth::user()->last_name,
                'email' => Auth::user()->email,
                'fcm_token' => Auth::user()->fcm_token,
                'provider' => Auth::user()->provider,
                'is_completed' => Auth::user()->userLocation ? 1:0,
                'profile_image' => Auth::user()->profile_image,
                'city' => Auth::user()->userLocation ? Auth::user()->userLocation->city: null,
                'country' => Auth::user()->userLocation ? Auth::user()->userLocation->country: null,
                'lat' => Auth::user()->userLocation ? Auth::user()->userLocation->lat: null,
                'lng' => Auth::user()->userLocation ? Auth::user()->userLocation->lng: null,
                'user_id' => Auth::user()->id
            ];

            DB::commit();
            return makeResponse('success', $message, 200, $data, $token);
        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Server Error During Social Login: ' .$e, 500);
        }
    }


    public function loginWithFb($request)
    {
        $name = explode(' ',$request->full_name);


        $user = User::create([
            'first_name' => isset($name[0]) ? $name[0] : null,
            'last_name' => isset($name[1]) ? $name[1] : null,
            'profile_image' => $request->image,
            'uuid' => $request->uuid,
            'role_id' => 2,
            'provider' => $request->provider,
            'fcm_token' => $request->fcm_token,
            'user_name' => $request->full_name,

        ]);


        return $user;
    }

    public function loginWithApple($request)
    {
        $name = explode(' ',$request->full_name);

        $user = User::create([
            'first_name' => isset($name[0]) ? $name[0] : null,
            'last_name' => isset($name[1]) ? $name[1] : null,
            'user_name' => $request->full_name,
            'email' => $request->email,
            'uuid' => $request->uuid,
            'role_id' => 2,
            'provider' => $request->provider,
            'fcm_token' => $request->fcm_token,

        ]);
        return $user;
    }


    public function loginWithGmail($request)
    {
        $name = explode(' ',$request->full_name);

        $user = User::create([
            'first_name' => isset($name[0]) ? $name[0] : null,
            'last_name' => isset($name[1]) ? $name[1] : null,
            'email' => $request->email,
            'uuid' => $request->uuid,
            'role_id' => 2,
            'provider' => $request->provider,
            'fcm_token' => $request->fcm_token,
            'user_name' => $request->full_name,

        ]);


        return $user;
    }



}

