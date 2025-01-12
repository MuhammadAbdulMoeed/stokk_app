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
        return $loginService->loginWithEmail($request);
    }

    public function socialLogin(SocialLoginRequest $request,LoginService $loginService)
    {
        return $loginService->socialLogin($request);
    }
}
