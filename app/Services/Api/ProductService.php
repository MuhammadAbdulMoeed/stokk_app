<?php


namespace App\Services\Api;


use App\Helper\ImageUploadHelper;
use App\Models\Chat;
use App\Models\CustomField;
use App\Models\PivotProductCustomField;
use App\Models\Product;
use App\Models\ProductImage;
use App\Traits\ProductFetchTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductService
{
    use ProductFetchTrait;

    public function save($request)
    {
        DB::beginTransaction();

        try {
            $product = Product::create(['name' => $request->name, 'category_id' => $request->category_id,
                'location' => $request->location, 'lat' => $request->lat, 'lng' => $request->lng,
                'currency' => $request->currency, 'description' => $request->description,
                'type' => $request->type,
                'price' => $request->type == 'for_sale' ? $request->price : null,
                'per_month_rent_price' => $request->type == 'for_rent' ? $request->per_month_rent_price : null,
                'per_hour_rent_price' => $request->type == 'for_rent' ? $request->per_month_rent_price : null,
                'per_day_rent_price' => $request->type == 'for_rent' ? $request->per_month_rent_price : null,
                'sub_category_id' => $request->sub_category_id, 'created_by' => Auth::user()->id, 'is_active' => 1]);
        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Saving Product: ' . $e, 500);
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

                    PivotProductCustomField::create(['product_id' => $product->id,
                        'custom_field_id' => $customFieldId,
                        'value' => $value]);
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Saving Custom Field: ' . $e, 500);
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
            return makeResponse('success', 'Product Save Successfully', 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return makeResponse('error', 'Error in Saving Product Image: ' . $e, 500);

        }
    }


    public function detail($request)
    {
        $data = Product::find($request->product_id);


        if ($data) {
            $productDetail = array();
            $lastFieldId = null;


            //parent products
            foreach ($data->customFieldRelate as $relatedField) {


                if (sizeof($relatedField->customFieldOption) > 0) {
                    $value = array();
                    foreach($relatedField->customFieldOption as $customFieldOption)
                    {
                        if($customFieldOption->id == $relatedField->pivot->value)
                        {
                            $value[] = $customFieldOption->name;
                        }
                    }

                    $productDetail[] = [
                        'field_name' => $relatedField->name,
                        'value' => $value
                    ];
                }
                else {

                    if ($relatedField->type == 'custom_field') {

                        $productDetail[] = [
                            'field_name' => $relatedField->name,
                            'value' => [$relatedField->pivot->value]
                        ];
                    }
                    elseif ($relatedField->type == 'pre_included_field') {

                        if ($lastFieldId == $relatedField->id) {
                            break;
                        } else {

                            $lastFieldId = $relatedField->id;


                            $value = array();
                            if ($relatedField->field_type == 'multi_select_option') {
                                $getMultipleValue = PivotProductCustomField::where('product_id', $data->id)
                                    ->where('custom_field_id', $relatedField->id)
                                    ->get();
                                foreach ($getMultipleValue as $fieldValue) {
                                    $value[] = $fieldValue->value;
                                }
                            } else {
                                $value[] = $relatedField->pivot->value;
                            }


                            if ($relatedField->field_type == "multi_select_option") {
                                $fieldValue = DB::table($relatedField->value_taken_from)
                                    ->whereIn('id', $value)
                                    ->pluck('name')->toArray();

                            } else {
                                $fieldValue = DB::table($relatedField->value_taken_from)
                                    ->whereIn('id', $value)
                                    ->pluck('name')->toArray();

                            }
                        }


                        $productDetail[] = [
                            'field_name' => $relatedField->name,
                            'value' => $fieldValue
                        ];
                    }

                }

            }

            //child products
            foreach ($data->customFieldRelated as $relatedField) {
                $productDetail[] = [
                    'field_name' => $relatedField->name,
                    'value' => $relatedField->pivot->value
                ];
            }


            //create response for sending detail or product
            $product = $this->fetchSingleProduct($data);
//            $product['description'] = $data->description;
//            $product['type'] = $data->type;
//            $product['price'] = $data->type == 'for_sale' ? $data->price : null;
//            $product['monthly_price'] = $data->type == 'for_rent' ? $data->per_month_rent_price : null;
//            $product['daily_price'] = $data->type == 'for_rent' ? $data->per_day_rent_price : null;
//            $product['hourly_price'] = $data->type == 'for_rent' ? $data->per_hour_rent_price : null;
            $product['created_by'] = $data->user->first_name . ' ' . $data->user->last_name;
            $product['creator_image'] =  $data->user->profile_image;
            $product['fields'] = $productDetail;
//            $product['location'] = $data->location;
            $product['cart_available'] = $data->created_by == Auth::user()->id ? 'no' : 'yes';

            $relatedProductsArray = Product::where('category_id',$data->category_id)
                ->where('sub_category_id',$data->sub_category_id)
                ->where('id','!=',$data->id)
                ->where('created_by','!=',Auth::user()->id)
                ->where('is_active',1)
                ->get();

            $relatedProducts = $this->fetchProduct($relatedProductsArray);


            $productUser =  $data->created_by;

            //findUserChat
            $userChat = Chat::with(['firstUser', 'secondUser'])->where(function ($query) use ($user_id,$productUser) {
                $query->where('user_1', Auth::user()->id)->where('user_2', $productUser);
            })->orwhere(function ($query) use ($user_id,$productUser) {
                $query->where('user_1', $productUser)->where('user_2', Auth::user()->id);
            })
                ->first();

            $conversation_id = null;
            if($userChat)
            {
                $conversation_id = $userChat->id;
            }

            $data = [
                'product_detail' => $product,
                'related_products' =>  $relatedProducts,
                'conversation_id' => $conversation_id
            ];


            return makeResponse('success', 'Detail Fetch Successfully', 200, $data);

        } else {
            return makeResponse('error', 'Product Not Found', 500);
        }
    }
}
