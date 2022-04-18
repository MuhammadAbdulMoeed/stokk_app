<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\Api\Auth\LogoutService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request,LogoutService $logoutService)
    {
        return $logoutService->logout($request);
    }
}
