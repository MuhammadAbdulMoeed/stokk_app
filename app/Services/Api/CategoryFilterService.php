<?php


namespace App\Services\Api;


use App\Models\Category;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\Filter;
use App\Models\FilterValue;
use App\Models\PivotCategoryField;
use App\Models\PivotCategoryFilter;
use App\Models\PivotProductCustomField;
use App\Models\Product;
use App\Traits\ProductFetchTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CategoryFilterService
{
    use ProductFetchTrait;

    public function getCategoryFilter($request)
    {
        $getFilterRecords = PivotCategoryFilter::where('category_id', $request->category_id)
            ->orderBy('order', 'asc')->pluck('filter_id')->toArray();

        $customFields = CustomField::whereIn('id', $getFilterRecords)->with('customFieldOption')
            ->where('filter', 1)
            ->orderBy('id', 'asc')
            ->get();

        $custom_fields = array();

        foreach ($customFields as $customField) {
            $filter = array();
            $filterRecords = array();

            $getCategory = Category::find($request->category_id);

            if ($customField->is_active == 1) {

                if ($customField->type == 'pre_included_field') {
                    $filter = ['name' => $customField->name, 'type' => $customField->filter_field_type,
                        'id' => $customField->id, 'slug' => $customField->slug,
                        'min' => $customField->min ? $customField->min : null, 'max' => $customField->max ? $customField->max : null
                    ];

                    if ($customField->value_taken_from == 'categories') {
                        $getSubCategories = DB::table($customField->value_taken_from)
                            ->where('parent_id', $request->category_id)
                            ->select('name', 'id')
                            ->where('is_active', 1)
                            ->get()->toArray();
                    } else if ($customField->value_taken_from == 'additional_options' || $customField->value_taken_from == 'item_conditions') {
                        $getSubCategories = DB::table($customField->value_taken_from)
                            ->select('name', 'id')
                            ->where('is_active', 1)
                            ->get()->toArray();
                    }
                    else if ($customField->value_taken_from == 'brands') {
                        $getCategoriesBrands = DB::table($customField->value_taken_from)
                            ->select('name', 'id','icon')
                            ->where('is_active', 1)
                            ->where('parent_category_id',$request->category_id)
                            ->get()->toArray();

                        $getSubCategoriesBrands = DB::table($customField->value_taken_from)
                            ->select('name', 'id','icon')
                            ->where('is_active', 1)
                            ->whereIn('category_id',$getCategory->subCategory->pluck('id')->toArray())
                            ->get()->toArray();

                        $getSubCategories = array_diff($getCategoriesBrands,$getSubCategoriesBrands);



                    }
                    else {
                        $getSubCategories = DB::table($customField->value_taken_from)
                            ->select('name', 'id', 'icon')
                            ->whereIn('category_id', $getCategory->subCategory->pluck('id')->toArray())
                            ->where('is_active', 1)
                            ->get()->toArray();
                    }

                    $filterRecords = $getSubCategories;


                } elseif ($customField->type == 'custom_field') {
                    $filter = ['name' => $customField->name, 'type' => $customField->filter_field_type,
                        'id' => $customField->id, 'slug' => $customField->slug,
                        'min' => $customField->min, 'max' => $customField->max
                    ];

                    if ($customField->field_type == 'simple_select_option' || $customField->field_type == 'multi_select_option') {
                        $fieldRecords = CustomFieldOption::with('relatedFields')
                            ->where('custom_field_id', $customField->id)
                            ->select('name', 'id')->get();
                    }
                }


                $custom_fields[] = ['filter' => $filter, 'filter_records' => $filterRecords];

            }
        }

        return makeResponse('success', 'Filter Retrieve Successfully', 200, $custom_fields);
    }

    public function applyFilter($request)
    {

        $whereStatement = array();

        $getFilterRecords = PivotCategoryFilter::where('category_id', $request->category_id)
            ->orderBy('order', 'asc')->pluck('filter_id')->toArray();


        $i = 1;

        if (empty($getFilterRecords))
        {
            return makeResponse('error','Filters For That Category Does not Exist',500);
        }



        foreach ($request->filters as $key => $filter) {
            $checkFilter = in_array($filter['id'], $getFilterRecords);



            if (!$checkFilter) {
                return makeResponse('error', 'Filter Record Not Exist In: ' . $filter['id'], 500);
            }

            $getFieldRecord = CustomField::find($filter['id']);
            $operator = '=';

            if($getFieldRecord->type == 'custom_field' && $getFieldRecord->field_type == 'number_field')
            {
                $operator = '>=';
            }


            if($key == 0)
            {
                $whereStatement[$key] = "( custom_field_id = " . $filter['id'] . " AND value ".$operator.''. $filter['value'] . ")";
            }
            else {

                if (sizeof($request->filters) == $i || $key != 0) {
                    $whereStatement[$key] = "OR ( custom_field_id = " . $filter['id'] . " AND value  ".$operator.'' . $filter['value'] . ")";
                } else {
                    $whereStatement[$key] = "( custom_field_id = " . $filter['id'] . " AND value ".$operator.'' . $filter['value'] . ")";

                }
            }

            $i++;
        }





        $products = Product::where('category_id', $request->category_id);

        if ($request->has('sub_category_id')) {
            $products = $products->where('sub_category_id', $request->sub_category_id);
        }

        $allCategorySubCategoryProducts = $products->pluck('id')->toArray();


        $finalProducts = array();

        $statement = implode($whereStatement, ' ');

//        dd($statement);

        $record = PivotProductCustomField::select('product_id')->whereRaw($statement)->distinct()->get();

//        dd($record);


        foreach ($record as $singleRecord) {
            if (in_array($singleRecord->product_id, $allCategorySubCategoryProducts)) {
                $finalProducts[] = $this->fetchSingleProduct($singleRecord->product);
            }

        }


        if (sizeof($finalProducts) > 0) {
            return makeResponse('success', 'Record Found', 200, $finalProducts);
        } else {
            return makeResponse('error', 'Record Not Found', 404);
        }


    }
}
