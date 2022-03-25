<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\SocialLoginRequest;
use App\Services\Api\Auth\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function emailLogin(LoginRequest $request,LoginService $loginService)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if ($validator->fails()) {
            return makeResponse('error',$validator->errors()->first(),422);
        }

        return $loginService->loginWithEmail($request);
    }

    public function socialLogin(SocialLoginRequest $request,LoginService $loginService)
    {
        $customMsg = [
            'email.required_if' => 'The email field is required'
        ];
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'uuid' => 'required|string',
            "provider" => "required|string|in:FACEBOOK,GMAIL,APPLE",
            'image' => 'mimes:png,jpeg,jpg',
            'email' => 'required_if:provider,GMAIL'
        ],$customMsg);

        if ($validator->fails()) {
            return makeResponse('error',$validator->errors()->first(),422);
        }

        return $loginService->socialLogin($request);

    }
}
