<?php


namespace App\Services\Api;


use App\Helper\ImageUploadHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProfileService
{
    public function getProfile()
    {
        $data = [ 'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'email' => Auth::user()->email,
            'fcm_token' => Auth::user()->fcm_token,
            'is_completed' => Auth::user()->userLocation ? 1:0,
            'provider' => Auth::user()->provider,
            'city' => Auth::user()->userLocation ? Auth::user()->userLocation->city: null,
            'country' => Auth::user()->userLocation ? Auth::user()->userLocation->country: null,
            'lat' => Auth::user()->userLocation ? Auth::user()->userLocation->lat: null,
            'lng' => Auth::user()->userLocation ? Auth::user()->userLocation->lng: null,
            'profile_image' => Auth::user()->profile_image,

        ];


        return makeResponse('success','Profile Retrieved Successfully',200,$data);
    }

    public function saveProfile($request)
    {

        DB::beginTransaction();
        try {
            if ($request->has('profile_image')) {
                $image = $request->profile_image;
                $ext = $image->getClientOriginalExtension();
                $fileName = $image->getClientOriginalName();
                $fileNameUpload = time() . "-." . $ext;
                $drive = 'upload/user/';
                $path = public_path($drive);
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0777, true);
                }

                $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $drive);
                $save_icon = $imageSave;

                Auth::user()->profile_image = $save_icon;

            }


            Auth::user()->first_name = $request->first_name;
            Auth::user()->last_name = $request->last_name;
            Auth::user()->user_name = $request->user_name;
            Auth::user()->date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d');
            Auth::user()->gender = $request->gender;
            Auth::user()->bio = $request->description;

            Auth::user()->save();

            $data = [
                'first_name' => Auth::user()->first_name, 'last_name' => Auth::user()->last_name,
                'user_name' => Auth::user()->user_name, 'date_of_birth' => Auth::user()->date_of_birth,
                'gender' => Auth::user()->gender, 'bio' => Auth::user()->bio,
                'profile_image' => Auth::user()->profile_image,'user_id' => Auth::user()->id
            ];

            DB::commit();
            return makeResponse('success', 'Profile Saved Successfully', 200, $data);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return makeResponse('error','Error in Saving Profile: '.$e,500);
        }
    }

    public function updateFCMToken($request)
    {
        DB::beginTransaction();

        try{
            Auth::user()->fcm_token = $request->fcm_token;
            Auth::user()->save();

            DB::commit();
            return makeResponse('success','Token Updated Successfully',200);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return makeResponse('error','Error in Update FCM Token: '.$e,500);
        }


    }
}
