<?php


namespace App\Services\Api\Auth;


use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    public function register($request)
    {
        DB::beginTransaction();

        try {
            $user = User::create($request->except('password') +
                ['password' => bcrypt($request->password), 'role_id' => 2]);

            $success['token'] = $user->createToken('ClassifiedMarketplace-' . rand(0, 9))->accessToken;

            $data = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ];

            DB::commit();
            return makeResponse("success", 'User Registered Successfully', 200, $data, $success['token']);


        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Creating User: ' . $e, 500);
        }
    }
}
