<?php


namespace App\Services\Admin\Auth;


use Illuminate\Support\Facades\Auth;

class LoginService
{
    public function loginPage()
    {
        return view('authentication.login');
    }

    public function login($request)
    {
        $credentials = $request->only('email', 'password');

        if ($request->remember_me) {
            $remember = true;
            if (Auth::attempt($credentials, $remember)) {
                //save user status
                $url = '';
                if (Auth::user()->role->name == 'Admin') {
//                    $url = route('adminDashboard');
                    $message = 'Login Successful';
                }

                return response()->json(['result' => 'success', 'message' => $message,
                    'data' => Auth::user()->role_id,
                    'url' => $url
                ], 200);


            }
            else {
                return response()->json(['result' => 'error', 'message' => 'Invalid Credentials'], 200);
            }
        }
        else {
            if (Auth::attempt($credentials)) {
                $url = '';
                if (Auth::user()->role->name == 'Admin') {
//                    $url = route('adminDashboard');
                    $message = 'Login Successful';
                }

                return response()->json(['result' => 'success', 'message' => $message,
                    'data' => Auth::user()->role_id,
                    'url' => $url
                ], 200);


            } else {
                return response()->json(['result' => 'error', 'message' => 'Invalid Credentials'], 200);
            }
        }

    }
}
