<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\Auth\LoginService;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function loginPage(LoginService $loginService)
    {
        dd(env('DB_PASSWORD'));
        return $loginService->loginPage();
    }

    public function login(LoginRequest $request,LoginService $loginService)
    {
        return $loginService->login($request);
    }
}
