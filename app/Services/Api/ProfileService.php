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
        $data = ['first_name' => Auth::user()->first_name,'last_name' => Auth::user()->last_name,
            'profile_image' => Auth::user()->profile_image, 'user_name' => Auth::user()->user_name,
            'gender' => Auth::user()->gender, 'date_of_birth' => Auth::user()->date_of_birth,
            'description' => Auth::user()->bio
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
                'profile_image' => Auth::user()->profile_image,
            ];

            DB::commit();
            return makeResponse('success', 'Profile Saved Successfully', 200, $data);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return makeResponse('error','Error in Saving Profile',500);
        }
    }
}
