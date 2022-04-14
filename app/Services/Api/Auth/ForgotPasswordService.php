<?php


namespace App\Services\Api\Auth;


use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordService
{
    public function forgetPasswordForm($request)
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return makeResponse('error', 'Invalid Email Address', 401);
            }

            $check = PasswordReset::where('email', $request->email)->first();

            if(!$check)
            {
                $check = new PasswordReset();
            }

            $confirmation_code = mt_rand(1000, 9999);

            $check->email = $request->email;
            $check->token = $confirmation_code;

            $check->save();


            $data = [
                'confirmation_code' => $confirmation_code,
                'email' => $user->email,
            ];

            Notification::send($user, new ResetPasswordNotification($data));


            DB::commit();
            return makeResponse('success', 'OTP Code is Send to your Email Address', 200);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return makeResponse('error','Error Occur During Sending Email: '.$e,500);
        }

    }

    public function verifyOtp($request)
    {

        DB::beginTransaction();
        $otp = PasswordReset::where('email', $request->email)->where('token', $request->otp)
            ->first();

        if (!$otp) {
            DB::rollBack();
            return makeResponse('error', 'Invalid OTP Code', 401);
        }

        $otp->delete();

        DB::commit();
        return makeResponse('success', 'OTP Verified Successfully', 200);

    }

    public function changePassword($request)
    {
        DB::beginTransaction();
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            DB::rollBack();
            return makeResponse('error', "Email does not Exist", 401);
        }


        $user->password = bcrypt($request->password);
        $user->save();

        DB::commit();
        return makeResponse('success', "Password Updated Successfully", 200);


    }

    public function resendOtp($request)
    {
        DB::beginTransaction();
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            DB::rollBack();
            return makeResponse('error', 'Email does not Exist', 401);
        }

        $email = PasswordReset::where('email', $request->email)->first();

        if (!$email) {
            $email = new PasswordReset();
            $email->email =  $request->email;
        }

        $confirmation_code = mt_rand(1000, 9999);

        $email->token = $confirmation_code;
        $email->save();
        $data = [

            'confirmation_code' => $confirmation_code,
            'email' => $user->email,
        ];

        Notification::route('mail', env('MAIL_FROM_ADDRESS'))->notify(new ResetPasswordNotification($data));
        DB::commit();
        return makeResponse('success', 'OTP Code is Send to your Email Address', '200');
    }
}
