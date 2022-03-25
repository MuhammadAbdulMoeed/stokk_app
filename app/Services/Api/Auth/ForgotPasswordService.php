<?php


namespace App\Services\Api\Auth;


class ForgotPasswordService
{
    public function forgetPasswordForm($request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->messages()->first()], 200);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['status' => 0, 'message' => "Email Not Found"], 200);
        }

        $confirmation_code = mt_rand(1000, 9999);
        PasswordReset::insert([
            'email' => $request->email,
            'token' => $confirmation_code]);

        $data = [
            'confirmation_code' => $confirmation_code,
            'email' => $user->email,
        ];

        Notification::route('mail', env('MAIL_CLIENT'))->notify(new ResetPassword($data));


        return response()->json(['status' => 1, 'message' => 'OTP Code is send to your Email Address',
            'email' => $user->email], 200);


    }

    public function verifyOtp($request)
    {
        $validator = Validator::make($request->all(), [

            'otp' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->messages()->first()], 200);
        }

        $otp = PasswordReset::where('email', $request->email)->where('token', $request->otp)
            ->first();

        if (!$otp) {
            return response()->json(['status' => 0, 'message' => "Invalid OTP Code"], 200);
        }

        $otp->delete();

        return response()->json(['status' => 1, 'message' => "OTP Verified Successfully"], 200);

    }

    public function changePassword($request)
    {
        $customMsgs = [
            'email.required' => 'Please Provide Email',
            'password.required' => 'Please Provide Password',
        ];
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|confirmed|min:8',
            ], $customMsgs
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->messages()->first()], 200);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 0, 'message' => "Email does not Exist"], 200);
        }


        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => 1, 'message' => "Password Updated Successfully"], 200);


    }

    public function resendOtp($request)
    {
        $customMsgs = [
            'email.required' => 'Please provide Email',
        ];
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
            ], $customMsgs
        );

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->messages()->first()], 200);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 0, 'message' => "Email doe's not Exist"], 200);
        }

        $email = PasswordReset::where('email', $request->email)->first();

        $confirmation_code = mt_rand(1000, 9999);

        $email->token = $confirmation_code;
        $email->save();
        $data = [

            'confirmation_code' => $confirmation_code,
            'email' => $user->email,
        ];

        Notification::route('mail', env('MAIL_CLIENT'))->notify(new ResetPassword($data));

        return response()->json(['status' => 1, 'message' => 'OTP Code is Resend to your Email Address',
            'email' => $user->email], 200);

    }
}
