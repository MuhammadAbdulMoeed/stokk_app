<?php


namespace App\Services\Admin;


use App\Helper\ImageUploadHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CustomField;
use App\Models\PivotCategoryField;
use App\Models\PivotProductCustomField;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductService
{
    public function index()
    {
        $data = Product::all();
        return view('admin.product.listing', compact('data'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->where('is_active', 1)->get();

        return view('admin.product.create', compact('categories'));
    }

    public function save($request)
    {
        DB::beginTransaction();

        try {
            $product = Product::create(['name' => $request->name, 'category_id' => $request->category_id,
                'location' => $request->location, 'lat' => $request->lat, 'lng' => $request->lng,
                'currency' => $request->currency,
                'sub_category_id' => $request->sub_category_id, 'created_by' => Auth::user()->id, 'is_active' => 1]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Product: ' . $e]);
        }

        try {
            foreach ($request->custom_fields as $customFieldId => $value) {
                $findCustomField = CustomField::find($customFieldId);

                if (!$findCustomField) {
                    return response()->json(['result' => 'error', 'message' => 'Custom Field Not Found']);
                }

                if ($findCustomField->is_required == 1 && $value == null) {
                    if($findCustomField->parent_id )
                    {
                        if($findCustomField->option_id == $request->custom_fields[$findCustomField->parent_id])
                        {
                            return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                        }
                        else{
                            continue;
                        }
                    }
                    else {
                        return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                    }
                }

                PivotProductCustomField::create(['product_id' => $product->id,
                    'custom_field_id' => $customFieldId,
                    'value' => $value]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Product Custom Field: ' . $e]);
        }

        try {
            if (sizeof($request->new_gallery) > 0) {
                foreach ($request->new_gallery as $key => $productImage) {

                    $image = $productImage;

                    $ext = $image->getClientOriginalExtension();
                    $fileName = $image->getClientOriginalName();
                    $fileNameUpload = time() . "-" . $key+1 .'-'.$ext;
                    $drive = 'upload/product/images/';
                    $path = public_path($drive);
                    if (!file_exists($path)) {
                        File::makeDirectory($path, 0777, true);
                    }

                    $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $drive);
                    $save_image = $imageSave;

                    ProductImage::create(['image' => $save_image, 'product_id' => $product->id]);

                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Product Image: ' . $e]);
        }

        DB::commit();
        return response()->json(['result' => 'success', 'message' => 'Product Save Successfully']);

    }

    public function edit($id)
    {
        $data = Product::find($id);

        if ($data) {
            $categories = Category::whereNull('parent_id')->where('is_active', 1)->get();
            $subCategories = Category::where('parent_id', $data->category_id)->get();

            $relatedFields = array();

            foreach ($data->customField as $key => $customField) {
                if (sizeof($customField->getChild) > 0) {
                    foreach ($customField->getChild as $getChild) {
                        $relatedFields[$getChild->customFieldOptionSelected->id][] = $getChild;
                    }
                }
            }


            return view('admin.product.edit', compact('data', 'categories', 'subCategories',
                'relatedFields'));
        } else {
            return redirect()->route('productListing')->with('error', 'Record Not Found');
        }
    }

    public function update($request)
    {
        DB::beginTransaction();

        $data = Product::find($request->id);
        if ($data) {
            try {
                $data->update(['name' => $request->name, 'category_id' => $request->category_id,
                    'location' => $request->location, 'lat' => $request->lat, 'lng' => $request->lng,
                    'currency' => $request->currency,
                    'sub_category_id' => $request->sub_category_id, 'created_by' => Auth::user()->id, 'is_active' => 1]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['result' => 'error', 'message' => 'Error in Saving Product: ' . $e]);
            }

            try {
                PivotProductCustomField::where('product_id',$data->id)->delete();
                foreach ($request->custom_fields as $customFieldId => $value) {
                    $findCustomField = CustomField::find($customFieldId);

                    if (!$findCustomField) {
                        return response()->json(['result' => 'error', 'message' => 'Custom Field Not Found']);
                    }

                    if ($findCustomField->is_required == 1 && $value == null) {
                        if($findCustomField->parent_id )
                        {
                            if($findCustomField->option_id == $request->custom_fields[$findCustomField->parent_id])
                            {
                                return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                            }
                            else{
                                continue;
                            }
                        }
                        else{
                            return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                        }

                    }


                    PivotProductCustomField::create(['product_id' => $data->id,
                        'custom_field_id' => $customFieldId,
                        'value' => $value]);
                }

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['result' => 'error', 'message' => 'Error in Saving Product Custom Field: ' . $e]);
            }

            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'Product Updated Successfully']);
        } else {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }

    }

    public function delete($request)
    {

    }

    public function deleteGallery($id)
    {
        $gallery = ProductImage::find($id);
        if ($gallery) {
            if (File::exists(public_path($gallery->images))) {
                File::delete(public_path($gallery->images));
            }
            $gallery->delete();
            return response()->json(['result' => 'success', 'message' => 'Gallery Image Deleted.']);

        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }

    }


    public function updateGallery($request)
    {
        $data = Product::find($request->product_id);
        if ($data) {

            if ($request->has('image')) {
                $image = $request->image;
                $ext = $image->getClientOriginalExtension();
                $fileName = $image->getClientOriginalName();
                $fileNameUpload = time() . "-" . $ext;
                $path = public_path('upload/product/images/');
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0777, true);
                }
                $galleryImage = ImageUploadHelper::saveImage($image, $fileNameUpload, 'upload/product/images/');

                $productImage = ProductImage::create(['image' => $galleryImage,
                    'product_id' => $request->product_id]);

                $productImage->image =  asset($productImage->image);

                return response()->json(['result' => 'success', 'message' => 'Product Gallery Image Uploaded','data'=>$productImage]);

            } else {
                return response()->json(['result' => 'error', 'message' => 'Image Not Found']);
            }
        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }



}
