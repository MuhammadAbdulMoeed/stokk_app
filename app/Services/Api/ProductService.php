<?php


namespace App\Services\Api;


use App\Helper\ImageUploadHelper;
use App\Models\CustomField;
use App\Models\PivotProductCustomField;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductService
{
    public function save($request)
    {
        DB::beginTransaction();

        try {
            $product = Product::create(['name' => $request->name, 'category_id' => $request->category_id,
                'location' => $request->location, 'lat' => $request->lat, 'lng' => $request->lng,
                'currency' => $request->currency,'description' => $request->description,
                'sub_category_id' => $request->sub_category_id, 'created_by' => Auth::user()->id, 'is_active' => 1]);
        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error','Error in Saving Product: ' . $e,500);
        }

        try {
            foreach ($request->custom_fields as $customFieldId => $value) {
                $findCustomField = CustomField::find($customFieldId);

                if (!$findCustomField) {
                    return makeResponse('error','Custom Field Not Found: ' . $customFieldId,500);

                }

                if ($findCustomField->is_required == 1 && $value == null) {
                    if ($findCustomField->parent_id) {
                        if ($findCustomField->option_id == $request->custom_fields[$findCustomField->parent_id]) {
                            return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                        } else {
                            continue;
                        }
                    } else {
                        return makeResponse('error',$findCustomField->name . ' is a Required Field',422);

                    }
                }

                PivotProductCustomField::create(['product_id' => $product->id,
                    'custom_field_id' => $customFieldId,
                    'value' => $value]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error','Error in Saving Custom Field: ' . $e,500);
        }

        try {

            foreach ($request->images as $key => $productImage) {


                $image = $productImage;

                $ext = $image->getClientOriginalExtension();
                $fileName = $image->getClientOriginalName();
                $fileNameUpload = time() . "-" . $key . '-.' . $ext;
                $drive = 'upload/product/images/';
                $path = public_path($drive);
                if (!file_exists($path)) {
                    File::makeDirectory($path, 0777, true);
                }

                $imageSave = ImageUploadHelper::saveImage($image, $fileNameUpload, $drive);
                $save_image = $imageSave;

                ProductImage::create(['image' => $save_image, 'product_id' => $product->id]);

            }

            DB::commit();
            return makeResponse('success','Product Save Successfully',200);

        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error','Error in Saving Product Image: ' . $e,500);

        }


    }
}
