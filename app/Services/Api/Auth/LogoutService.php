<?php


namespace App\Services\Api\Auth;


use Illuminate\Support\Facades\Auth;

class LogoutService
{
    public function logout($request)
    {
        $token = Auth::user()->token();
        $token->revoke();
        return makeResponse('success', 'You Have Been Successfully Logged Out!');
    }
}
