<?php


namespace App\Services\Admin;


use App\Helper\ImageUploadHelper;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class BrandService
{
    public function index()
    {
        $data = Brand::all();
        return view('admin.brand.listing', compact('data'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->where('is_active', 1)->get();
        return view('admin.brand.create', compact('categories'));
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
                $drive = 'upload/brand/';
                $path = public_path($drive);
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0777, true);
                }

                $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $drive);
                $save_icon = $imageSave;
            }


            Brand::create($request->except('_token', 'icon') + ['icon' => $save_icon]);

            return response()->json(['result' => 'success', 'message' => 'Category Save Successfully']);
        } catch (\Exception $e) {
            return response()->json(['result' => 'error', 'message' => 'Server Error in Saving Data: ' . $e]);
        }
    }


    public function edit($id)
    {
        $data = Brand::find($id);

        if ($data) {
            $categories = Category::whereNull('parent_id')->where('is_active', 1)->get();
            $subCategories = array();


            $subCategories = Category::where('parent_id', $data->parent_category_id)
                ->where('is_active', 1)
                ->get();




//            $subCategory = Category::
            return view('admin.brand.edit', compact('data', 'categories', 'subCategories'));

        } else {
            return redirect()->route('brandListing')->with('error', 'Record Not Found');
//            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function update($request)
    {

        $data = Brand::find($request->id);
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


                $data->update($request->except('_token', 'icon') + ['icon' => $save_icon]);

                return response()->json(['result' => 'success', 'message' => 'Brand Updated Successfully']);
            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Server Error in Updating Data: ' . $e]);
            }
        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function delete($request)
    {
        $data = Brand::find($request->id);

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
        $data = Brand::find($request->id);

        if ($data) {
            try {
                if ($data->is_active == 1) {
                    $isactive = 0;
                } else {
                    $isactive = 1;
                }
                $data->update(['is_active' => $isactive]);

                return response()->json(['result' => 'success', 'message' => 'Status Change']);

            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Error in Change Status: ' . $e]);
            }

        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function getSubCategory($request)
    {
        $data = Category::find($request->category_id);

        if ($data) {
            $subCategories = $data->subCategory;


            return response()->json(['result' => 'success', 'data' => $subCategories]);
        } else {
            return response()->json(['result' => 'error', 'message' => 'SubCategory Not Found']);
        }
    }

    public function getCategoryBrand($request)
    {
        $data = Brand::where('category_id', $request->category_id)->get();

        return response()->json(['result' => 'success', 'data' => $data]);


    }
}
