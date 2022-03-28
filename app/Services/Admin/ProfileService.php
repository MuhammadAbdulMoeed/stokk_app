<?php


namespace App\Services\Admin;


use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProfileService
{
    public function index()
    {
        return view('admin.profile.profile');
    }

    public function save($request)
    {
        DB::beginTransaction();
        try {
            if ($request->has('profile_image')) {
                $image = $request->profile_image;

                $ext = $image->getClientOriginalExtension();
                $fileName = $image->getClientOriginalName();
                $fileNameUpload = time() . "-" . $fileName;
                $drive = 'upload/user/images/';
                $path = public_path($drive);
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0777, true);
                }

                if (Auth::user()->profile_image) {
                    $image_path = Auth::user()->profile_image;  // Value is not URL but directory file path

                    if ($image_path) {
                        if (File::exists($image_path)) {
                            File::delete($image_path);
                        }
                    }
                }

                $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $drive);
                $save_image = $imageSave;
                Auth::user()->profile_image = $save_image;
            }

            Auth::user()->first_name = $request->first_name;
            Auth::user()->last_name = $request->last_name;
            Auth::user()->country = $request->country;

            Auth::user()->save();

            DB::commit();
            return response()->json(['result'=>'success','message'=>'Profile Updated Successfully']);

        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['result'=>'error','message'=>'Error in saving Profile: '.$e]);
        }

    }
}
