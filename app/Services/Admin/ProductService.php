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
           $product =  Product::create(['name' => $request->name, 'category_id' => $request->category_id,
                'location' => $request->location, 'lat' => $request->lat, 'lng' => $request->lng,
                'sub_category_id' => $request->sub_category_id,'created_by'=>Auth::user()->id,'is_active'=>1]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Product: ' . $e]);
        }

        try {
            foreach($request->custom_fields as $customFieldId =>  $value)
            {
                $findCustomField = CustomField::find($customFieldId);

                if(!$findCustomField)
                {
                    return response()->json(['result'=>'error','message'=>'Custom Field Not Found']);
                }

                if($findCustomField->is_required == 1 && $value == null)
                {
                    return response()->json(['result'=>'error','message'=>$findCustomField->name.' is a Required Field']);
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
            if(sizeof($request->image) > 0) {
                foreach ($request->image as $productImage) {

                    $image = $productImage;

                    $ext = $image->getClientOriginalExtension();
                    $fileName = $image->getClientOriginalName();
                    $fileNameUpload = time() . "-" . $fileName;
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

    }

    public function update($request)
    {

    }

    public function delete($request)
    {

    }
}
