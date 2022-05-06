<?php


namespace App\Services\Api;


use App\Models\BlockUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlockUserService
{
    public function blockUser($request)
    {
        $check = BlockUser::where('blocked_user_id', $request->blocked_user_id)
            ->where('user_id', Auth::user()->id)->first();

        if ($check) {
            return makeResponse('success', 'User is already Blocked', 200);
        }
        try {
            DB::beginTransaction();
            BlockUser::create(['user_id' => Auth::user()->id, 'blocked_user_id' => $request->blocked_user_id]);

            DB::commit();
            return makeResponse('success', 'User is Blocked', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Block User: ' . $e, 500);
        }


    }

    public function unBlockUser($request)
    {
        $check = BlockUser::where('blocked_user_id', $request->blocked_user_id)
            ->where('user_id', Auth::user()->id)->first();

        if (!$check) {
            return makeResponse('error', 'User is not in Block List', 404);
        }
        try {
            DB::beginTransaction();
            $check->delete();

            DB::commit();
            return makeResponse('success', 'User is Unblock', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in UnBlock User: ' . $e, 500);
        }


    }

}
