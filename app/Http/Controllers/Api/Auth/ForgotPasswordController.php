<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
use App\Services\Api\Auth\ForgotPasswordService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request,ForgotPasswordService $forgotPasswordService)
    {
        return $forgotPasswordService->forgetPasswordForm($request);
    }

    public function verifyOtp(VerifyOtpRequest $request,ForgotPasswordService $forgotPasswordService)
    {
        return $forgotPasswordService->verifyOtp($request);
    }

    public function updatePassword(ChangePasswordRequest $request,ForgotPasswordService $forgotPasswordService)
    {
        return $forgotPasswordService->changePassword($request);
    }

    public function resendOTP(ForgotPasswordRequest $request,ForgotPasswordService $forgotPasswordService)
    {
        return $forgotPasswordService->resendOtp($request);
    }
}
