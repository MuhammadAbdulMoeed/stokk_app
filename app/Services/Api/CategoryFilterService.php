<?php


namespace App\Services\Api;


use App\Models\Category;
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

        $filters = Filter::whereIn('id', $getFilterRecords)->with('filterOptions')
            ->orderBy('id', 'asc')
            ->get();

        $custom_filters = array();

        foreach ($filters as $singleFilter) {
            $filter = array();
            $filterRecords = array();

            $getCategory = Category::find($request->category_id);

            if ($singleFilter->is_active == 1) {
                if ($singleFilter->filter_type == 'pre_included_filter') {
                    $filter = ['name' => $singleFilter->filter_name, 'type' => $singleFilter->field_type,
                        'id' => $singleFilter->id, 'slug' => $singleFilter->slug, 'min' => $singleFilter->min,
                        'max' => $singleFilter->max
                    ];

                    if ($singleFilter->field_type == 'categories') {
                        $getSubCategories = DB::table($singleFilter->field_type)
                            ->where('parent_id', $request->category_id)
                            ->select('name', 'id')
                            ->where('is_active', 1)
                            ->get()->toArray();
                    } else if ($singleFilter->field_type == 'additional_options') {
                        $getSubCategories = DB::table($singleFilter->field_type)
                            ->select('name', 'id')
                            ->where('is_active', 1)
                            ->get()->toArray();
                    } else {
                        $getSubCategories = DB::table($singleFilter->field_type)
                            ->select('name', 'id', 'icon')
                            ->whereIn('category_id', $getCategory->subCategory->pluck('id')->toArray())
                            ->where('is_active', 1)
                            ->get()->toArray();
                    }

                    $filterRecords = $getSubCategories;


                } elseif ($singleFilter->filter_type == 'custom_filter') {
                    $filter = ['name' => $singleFilter->filter_name, 'type' => $singleFilter->field_type,
                        'id' => $singleFilter->id, 'slug' => $singleFilter->slug, 'min' => $singleFilter->min,
                        'max' => $singleFilter->max
                    ];

                    if ($singleFilter->field_type == 'simple_select_option' || $singleFilter->field_type == 'multi_select_option') {
                        $filterRecords = FilterValue::with('filter')
                            ->where('filter_id', $singleFilter->id)
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

        $getFilterRecords = PivotCategoryField::where('category_id', $request->category_id)
            ->orderBy('order', 'asc')->pluck('custom_field_id')->toArray();


        foreach ($request->filters as $key => $filter) {
            $checkFilter = in_array($key, $getFilterRecords);

            if (!$checkFilter) {
                return makeResponse('error', 'Filter Record Not Exist In: ' . $key, 500);
            }


        }


        $products = Product::where('category_id', $request->category_id);

        if($request->has('sub_category_id'))
        {
            $products = $products->where('sub_category_id',$request->sub_category_id);
        }

        $allCategorySubCategoryProducts = $products->pluck('id')->toArray();



        $finalProducts = array();
        $whereStatement = array();

        foreach($allCategorySubCategoryProducts as $key => $product)
        {
            $i = 1;
            foreach($request->filters as $key1 => $value)
            {

                if(sizeof($request->filters) == $i)
                {
                    $whereStatement[$key1] = "OR ( custom_field_id = ".$key1." AND value >= ".$value.")";
                }
                else{
                    $whereStatement[$key1] = "( custom_field_id = ".$key1." AND value >=". $value.")";
                }

                $i++;
            }


//
//           dd( $product->customFieldHasMany->where('custom_field_id',array_keys($request->filters))
//
//           );


//            foreach($product->customFieldHasMany as $customFieldRecord)
//            {
//                if(in_array($customFieldRecord->custom_field_id,array_keys($request->filters)) && in_array($customFieldRecord->value,array_values($request->filters)))
//                {
//                    $finalProducts[$customFieldRecord->product_id] = $customFieldRecord->product_id;
//                }

//                foreach($request->filters as $key => $value)
//                {
//                    if($customFieldRecord->custom_field_id == $key)
//                    {
//                        if($customFieldRecord->value >= $value)
//                        {
//                            $finalProducts[$customFieldRecord->product_id] = $this->fetchSingleProduct($customFieldRecord->product);
//                        }
//                    }
//                }
//            }
        }


        $statement = implode($whereStatement,' ');

        $record = PivotProductCustomField::select('product_id')->whereRaw($statement)->distinct()->get();

        foreach($record  as $singleRecord)
        {
            if(in_array($singleRecord->product_id,$allCategorySubCategoryProducts))
            {
                $finalProducts[] = $this->fetchSingleProduct($singleRecord->product);
            }

        }



        if (sizeof($finalProducts) > 0) {
            return makeResponse('success','Record Found',200,$finalProducts);
        } else {
            return makeResponse('error', 'Record Not Found', 404);
        }


    }
}
