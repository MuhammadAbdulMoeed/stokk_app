<?php


namespace App\Services\Admin;


use App\Helper\ImageUploadHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
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
                'type' => $request->type,
                'description' => $request->description,
                'price' => $request->type == 'for_sale' ? $request->price : null,
                'per_month_rent_price' => $request->type == 'for_rent' ? $request->per_month_rent_price : null,
                'per_hour_rent_price' => $request->type == 'for_rent' ? $request->per_month_rent_price : null,
                'per_day_rent_price' => $request->type == 'for_rent' ? $request->per_month_rent_price : null,
                'sub_category_id' => $request->sub_category_id, 'created_by' => Auth::user()->id, 'is_active' => 1]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Product: ' . $e]);
        }

        try {
            foreach ($request->custom_fields as $customFieldId => $value) {

                if (is_array($value)) {
                    foreach ($value as $singleValue) {
                        $findCustomField = CustomField::find($customFieldId);

                        if (!$findCustomField) {
                            return response()->json(['result' => 'error', 'message' => 'Custom Field Not Found']);
                        }

                        if ($findCustomField->is_required == 1 && $singleValue == null) {
                            if ($findCustomField->parent_id) {
                                if ($findCustomField->option_id == $request->custom_fields[$findCustomField->parent_id]) {
                                    return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                                } else {
                                    continue;
                                }
                            } else {
                                return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                            }
                        }

                        PivotProductCustomField::create(['product_id' => $product->id,
                            'custom_field_id' => $customFieldId,
                            'value' => $singleValue]);
                    }
                }
                else {

                    $findCustomField = CustomField::find($customFieldId);

                    if (!$findCustomField) {
                        return response()->json(['result' => 'error', 'message' => 'Custom Field Not Found']);
                    }

                    if ($findCustomField->is_required == 1 && $value == null) {
                        if ($findCustomField->parent_id) {
                            if ($findCustomField->option_id == $request->custom_fields[$findCustomField->parent_id]) {
                                return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                            } else {
                                continue;
                            }
                        } else {
                            return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                        }
                    }

                    PivotProductCustomField::create(['product_id' => $product->id,
                        'custom_field_id' => $customFieldId,
                        'value' => $value]);
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Product Custom Field: ' . $e]);
        }

        try {
            foreach ($request->new_gallery as $key => $productImage) {


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
            return response()->json(['result' => 'success', 'message' => 'Product Save Successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Product Image: ' . $e]);
        }
    }

    public function edit($id)
    {
        $data = Product::find($id);

        if ($data) {
            $categories = Category::whereNull('parent_id')->where('is_active', 1)->get();
            $subCategories = Category::where('parent_id', $data->category_id)->get();

            $relatedFields = array();
            $field = array();
            $fieldRecords = array();
            $lastFieldId = '';
            foreach ($data->customField as $key => $customField) {
                $relatedFields = array();
                $field = array();
                $fieldRecords = array();

                if ($lastFieldId == $customField->id) {
                    break;
                }
                if ($customField->parent_id == null) {
                    $lastFieldId = $customField->id;
                    $value = array();
                    if ($customField->field_type == 'multi_select_option') {
                        $getMultipleValue = PivotProductCustomField::where('product_id', $id)
                            ->where('custom_field_id', $customField->id)
                            ->get();
                        foreach ($getMultipleValue as $fieldValue) {
                            $value[] = $fieldValue->value;
                        }
                    } else {
                        $value = $customField->pivot->value;
                    }
                    $field = ['id' => $customField->id, 'name' => $customField->name, 'slug' => $customField->slug,
                        'field_type' => $customField->field_type, 'order' => $customField->order,
                        'type' => $customField->type, 'parent_id' => $customField->parent_id,
                        'option_id' => $customField->option_id, "is_active" => $customField->is_active,
                        "is_required" => $customField->is_required,
                        'value_taken_from' => $customField->value_taken_from,
                        "value" => $value
                    ];

                    if ($customField->type == 'pre_included_field') {

                        if ($customField->value_taken_from == 'categories') {

                            $getSubCategories = DB::table($customField->value_taken_from)
                                ->where('parent_id', $data->category_id)
                                ->select('name', 'id')
                                ->where('is_active', 1)
                                ->get()->toArray();
                        } else if ($customField->value_taken_from == 'additional_options') {
                            $getSubCategories = DB::table($customField->value_taken_from)
                                ->select('name', 'id')
                                ->where('is_active', 1)
                                ->get()->toArray();
                        } else {
                            $getSubCategories = DB::table($customField->value_taken_from)
                                ->select('name', 'id', 'icon')
                                ->whereIn('category_id', $data->subCategory->pluck('id')->toArray())
                                ->where('is_active', 1)
                                ->get()->toArray();


                            if (sizeof($getSubCategories) <= 0) {
                                $getSubCategories = DB::table($customField->value_taken_from)
                                    ->select('name', 'id', 'icon')
                                    ->whereIn('category_id', $data->category_id)
                                    ->where('is_active', 1)
                                    ->get()->toArray();
                            }
                        }

                        $fieldRecords = $getSubCategories;
                    } else {
                        foreach ($customField->customFieldOption as $customChild) {
                            $fieldRecords[] = ['id' => $customChild->id,
                                'name' => $customChild->name
                            ];

                            if (sizeof($customChild->relatedFields) > 0) {
                                foreach ($customChild->relatedFields as $getChild) {
                                    $relatedFields[$getChild->customFieldOptionSelected->id][] = [
                                        'id' => $getChild->id, 'name' => $getChild->name,
                                        'slug' => $getChild->slug,
                                        'field_type' => $getChild->field_type, 'order' => $getChild->order,
                                        'type' => $getChild->type, 'parent_id' => $getChild->parent_id,
                                        'option_id' => $getChild->option_id, "is_active" => $getChild->is_active,
                                        "is_required" => $getChild->is_required,
                                        'value_taken_from' => $getChild->value_taken_from,
                                        "value" => isset($getChild->pivotTableValue) ? $getChild->pivotTableValue->value : '',
                                        'parent_main_name' => $customChild->name,
                                        'selected_parent_name' => $getChild->customFieldOptionSelected->name,
                                        'is_selected_value' => $customField->pivot->value,
                                        'grand_parent_name' => $getChild->parent->name
                                    ];

                                }

                            }
                        }


//                        if (sizeof($customField->getChild) > 0) {
//                            foreach ($customField->getChild as $getChild) {
//                                $fieldRecords[$getChild->customFieldOptionSelected->id][] =  [
//                                    'id' => $getChild->id, 'name' => $getChild->name,
//                                    'slug' => $getChild->slug,
//                                    'field_type' => $getChild->field_type, 'order' => $getChild->order,
//                                    'type' => $getChild->type, 'parent_id' => $getChild->parent_id,
//                                    'option_id' => $getChild->option_id, "is_active" => $getChild->is_active,
//                                    "is_required" => $getChild->is_required,
//                                    'value_taken_from' => $getChild->value_taken_from,
//                                    "value" => isset($getChild->pivotTableValue) ? $getChild->pivotTableValue->value:'',
//                                    'parent_main_name' => $customField->name,
//                                    'selected_parent_name' => $getChild->customFieldOptionSelected->name,
//                                    'is_selected_value' => $customField->pivot->value,
//                                ];
//
//                            }
//
//                        }
                    }
                } else {
                    $lastFieldId = $customField->id;

                    $field = ['id' => $customField->id, 'name' => $customField->name, 'slug' => $customField->slug,
                        'field_type' => $customField->field_type, 'order' => $customField->order,
                        'type' => $customField->type,
                        'parent_id' => $customField->parent_id, 'option_id' => $customField->option_id,
                        "is_required" => $customField->is_required, "is_active" => $customField->is_active,
                        'value_taken_from' => $customField->value_taken_from, "value" => $customField->pivot->value
                    ];

                    if (sizeof($customField->getChild) > 0) {
                        foreach ($customField->getChild as $getChild) {
                            $fieldRecords[$getChild->customFieldOptionSelected->id][] = [
                                'id' => $getChild->id, 'name' => $getChild->name,
                                'slug' => $getChild->slug,
                                'field_type' => $getChild->field_type, 'order' => $getChild->order,
                                'type' => $getChild->type, 'parent_id' => $getChild->parent_id,
                                'option_id' => $getChild->option_id, "is_active" => $getChild->is_active,
                                "is_required" => $getChild->is_required,
                                'value_taken_from' => $getChild->value_taken_from,
                                "value" => $getChild->pivotTableValue->value,
                                'parent_main_name' => $customField->name,
                                'selected_parent_name' => $getChild->customFieldOptionSelected->name
                            ];

                        }

                    }


                }

                $custom_fields[] = ['field' => $field, 'fieldRecord' => $fieldRecords, 'relatedFields' => $relatedFields];

            }


            return view('admin.product.edit', compact('data', 'categories', 'subCategories',
                'relatedFields', 'custom_fields'));
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
                    'type' => $request->type,
                    'description' => $request->description,
                    'price' => $request->type == 'for_sale' ? $request->price : null,
                    'per_month_rent_price' => $request->type == 'for_rent' ? $request->per_month_rent_price : null,
                    'per_hour_rent_price' => $request->type == 'for_rent' ? $request->per_month_rent_price : null,
                    'per_day_rent_price' => $request->type == 'for_rent' ? $request->per_month_rent_price : null,
                    'sub_category_id' => $request->sub_category_id, 'created_by' => Auth::user()->id, 'is_active' => 1]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['result' => 'error', 'message' => 'Error in Saving Product: ' . $e]);
            }

            try {
                PivotProductCustomField::where('product_id', $data->id)->delete();
                foreach ($request->custom_fields as $customFieldId => $value) {

                    if (is_array($value)) {
                        foreach ($value as $singleValue) {
                            $findCustomField = CustomField::find($customFieldId);

                            if (!$findCustomField) {
                                return response()->json(['result' => 'error', 'message' => 'Custom Field Not Found']);
                            }

                            if ($findCustomField->is_required == 1 && $value == null) {
                                if ($findCustomField->parent_id) {
                                    if ($findCustomField->option_id == $request->custom_fields[$findCustomField->parent_id]) {
                                        return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                                    } else {
                                        continue;
                                    }
                                } else {
                                    return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                                }

                            }


                            PivotProductCustomField::create(['product_id' => $data->id,
                                'custom_field_id' => $customFieldId,
                                'value' => $singleValue]);
                        }
                    } else {
                        $findCustomField = CustomField::find($customFieldId);

                        if (!$findCustomField) {
                            return response()->json(['result' => 'error', 'message' => 'Custom Field Not Found']);
                        }

                        if ($findCustomField->is_required == 1 && $value == null) {
                            if ($findCustomField->parent_id) {
                                if ($findCustomField->option_id == $request->custom_fields[$findCustomField->parent_id]) {
                                    return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                                } else {
                                    continue;
                                }
                            } else {
                                return response()->json(['result' => 'error', 'message' => $findCustomField->name . ' is a Required Field']);
                            }

                        }


                        PivotProductCustomField::create(['product_id' => $data->id,
                            'custom_field_id' => $customFieldId,
                            'value' => $value]);
                    }
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

                $productImage->image = asset($productImage->image);

                return response()->json(['result' => 'success', 'message' => 'Product Gallery Image Uploaded', 'data' => $productImage]);

            } else {
                return response()->json(['result' => 'error', 'message' => 'Image Not Found']);
            }
        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }


}
