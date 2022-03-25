<?php


namespace App\Services\Api\Auth;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginService
{
    public function loginWithEmail($request)
    {
        try {
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                $user = Auth::user();

                Auth::user()->fcm_token = $request->fcm_token;

                Auth::user()->save();

                $token = Auth::user()->createToken('ClassifiedMarketplace-' . rand(0, 9))->accessToken;

                $data = [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'fcm_token' => $user->fcm_token

                ];

                return makeResponse('success', 'Login Successfully', 200, $data, $token);
            } else {
                return makeResponse('error', 'Invalid Credentials', 401);
            }
        } catch (\Exception $e) {
            return makeResponse('error', 'Server Error During Login: ' . $e, 500);

        }
    }

    public function socialLogin($request)
    {
        DB::beginTransaction();
        try {
            $message = '';
            $user = User::where('uuid', $request->uuid)->where('provider', $request->provider)->first();

            if ($user) {

                $name = explode(' ',$request->full_name);
                $user->first_name = isset($name[0]) ? $name[0] : null;
                $user->last_name = isset($name[1]) ? $name[1] : null;
                $user->email = isset($request->email) ? $request->email : null;
                $user->uuid = $request->uuid;
                $user->provider = $request->provider;
                $user->save();

                $message = "Login Successfully";
            }
            else {
                if ($request->provider == 'FACEBOOK') {
                    $user = $this->loginWithFb($request);
                } elseif ($request->provider == 'APPLE') {
                    $user = $this->loginWithApple($request);
                } elseif ($request->provider == 'GMAIL') {
                    $user = $this->loginWithGmail($request);
                }
                $message = 'User Registered Successfully';
            }

            Auth::loginUsingId($user->id);
            $token = Auth::user()->createToken('ClassifiedMarketplace-' . rand(0, 9))->accessToken;

            DB::commit();
            return makeResponse('success', $message, 200, $user, $token);
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
            'provider' => $request->provider

        ]);
        return $user;
    }

    public function loginWithApple($request)
    {
        $name = explode(' ',$request->full_name);

        $user = User::create([
            'first_name' => isset($name[0]) ? $name[0] : null,
            'last_name' => isset($name[1]) ? $name[1] : null,
            'email' => $request->email,
            'uuid' => $request->uuid,
            'role_id' => 2,
            'provider' => $request->provider

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
            'provider' => $request->provider
        ]);
        return $user;
    }

}

