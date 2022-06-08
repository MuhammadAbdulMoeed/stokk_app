<?php


namespace App\Services\Admin;


use App\Helper\ImageUploadHelper;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CategoryService
{
    public function index()
    {
        $data = Category::all();
        return view('admin.category.listing', compact('data'));
    }

    public function create()
    {

        $parents = Category::whereNull('parent_id')->get();
        return view('admin.category.create', compact('parents'));
    }

    public function save($request)
    {
        try {
            $save_icon = null;
            if ($request->has('icon')) {
                $image = $request->icon;
                $ext = $image->getClientOriginalExtension();
                $fileName = $image->getClientOriginalName();
                $fileNameUpload = time() . "-" . $fileName;
                $drive = 'upload/category/';
                $path = public_path($drive);
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0777, true);
                }

                $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $drive);
                $save_icon = $imageSave;
            }

            $save_image = null;

            if ($request->file('image')) {
                $image = $request->image;
                $ext = $image->getClientOriginalExtension();
                $fileName = $image->getClientOriginalName();
                $fileNameUpload = time() . "-" . $fileName;
                $drive = 'upload/category/';
                $path = public_path($drive);
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0777, true);
                }

                $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $drive);
                $save_image = $imageSave;
            }

            $slug = null;
            if (!$request->slug) {
                $slug = strtoupper(str_slug($request->name, "_"));
            } else {
                $slug = $request->slug;

            }

            Category::create($request->except('_token', 'icon','image','slug') + ['icon' => $save_icon,'slug'=>$slug,
                    'image' => $save_image]);

            return response()->json(['result' => 'success', 'message' => 'Category Save Successfully']);
        } catch (\Exception $e) {
            return response()->json(['result' => 'error', 'message' => 'Server Error in Saving Data: ' . $e]);
        }
    }


    public function edit($id)
    {
        $data = Category::find($id);

        if ($data) {
            $parents = Category::where('id', '!=', $data->id)->whereNull('parent_id')->get();
            return view('admin.category.edit', compact('parents', 'data'));

        } else {
            return redirect()->route('categoryListing')->with('error','Record Not Found');
//            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function update($request)
    {

        $data = Category::find($request->id);
        if ($data) {
            try {
                $save_icon = $data->icon;
                if ($request->file('icon')) {
                    $image = $request->icon;
                    $ext = $image->getClientOriginalExtension();
                    $fileName = $image->getClientOriginalName();
                    $fileNameUpload = time() . "-" . $fileName;
                    $drive = 'upload/category/';
                    $path = public_path($drive);
                    if (!file_exists($path)) {
                        File::makeDirectory($path, 0777, true);
                    }

                    $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $drive);
                    $save_icon = $imageSave;
                }

                $save_image = $data->image;

                if ($request->file('image')) {
                    $image = $request->image;
                    $ext = $image->getClientOriginalExtension();
                    $fileName = $image->getClientOriginalName();
                    $fileNameUpload = time() . "-" . $fileName;
                    $drive = 'upload/category/';
                    $path = public_path($drive);
                    if (!file_exists($path)) {
                        File::makeDirectory($path, 0777, true);
                    }

                    $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $drive);
                    $save_image = $imageSave;
                }

                $slug = null;
                if (!$request->slug) {
                    $slug = strtoupper(str_slug($request->name, "_"));
                } else {
                    $slug = $request->slug;

                }
                $data->update($request->except('_token', 'icon','image','slug') + ['icon' => $save_icon,
                        'slug' => $slug, 'image'=>$save_image]);

                return response()->json(['result' => 'success', 'message' => 'Category Updated Successfully']);
            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Server Error in Updating Data: ' . $e]);
            }
        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function delete($request)
    {
        $data = Category::find($request->id);

        if ($data) {
            try {
                $data->delete();
                return response()->json(['result' => 'success', 'message' => 'Record Deleted']);

            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Error in Delete Data: ' . $e]);
            }

        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function changeStatus($request)
    {
        $data = Category::find($request->id);

        if ($data) {
            try {
                if($data->is_active == 1)
                {
                   $isactive = 0;
                }
                else{
                    $isactive = 1;
                }
                $data->update(['is_active'=>$isactive]);

                return response()->json(['result' => 'success', 'message' => 'Status Change']);

            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Error in Change Status: ' . $e]);
            }

        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }


    public  function removeBraces($str,$opbr = '(',$clbr = ')') {

        $rstr = trim($str);
        $leftchar = substr($rstr,0,1);
        $rightchar = substr($rstr,-1,1);
        if (($opbr == '(' and ($leftchar == '(' or $leftchar == '{' or $leftchar == '[')) or $leftchar == $opbr) {
            $rstr = substr($rstr,1);
        }
        if (($clbr == ')' and ($rightchar == ')' or $rightchar == '}' or $rightchar == ']')) or $rightchar == $clbr) {
            $rstr = substr($rstr,0,-1);
        }
        return $rstr;
    }

}
