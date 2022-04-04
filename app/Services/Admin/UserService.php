<?php


namespace App\Services\Admin;


use App\Helper\ImageUploadHelper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function index()
    {
        $data = User::where('role_id',2)->get();

        return view('admin.user.listing',compact('data'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function save($request)
    {
        DB::beginTransaction();
        try{
            $save_image = null;
            if($request->has('profile_image'))
            {
                $image = $request->profile_image;
                $ext = $image->getClientOriginalExtension();
                $fileName = $image->getClientOriginalName();
                $fileNameUpload = time() . "-" . $fileName;
                $drive = 'upload/user/';
                $path = public_path($drive);
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0777, true);
                }

                $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $drive);
                $save_image = $imageSave;
            }

            User::create($request->except('_token','profile_image','password','date_of_birth') +
                ['profile_image'=>$save_image, 'password'=>Hash::make('password'),
                    'role_id' => 2,
                    'date_of_birth'=>Carbon::parse($request->date_of_birth)->format('Y-m-d')]);

            DB::commit();
            return response()->json(['result'=>'success','message'=>'User Saved Successfully']);

        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['result'=>'error','message'=>'Error in Creating User: '.$e]);
        }
    }


}
