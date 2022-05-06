<?php


namespace App\Services\Api;


use App\Models\Category;
use App\Models\Filter;
use App\Models\FilterValue;
use App\Models\PivotCategoryFilter;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CategoryFilterService
{
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

        $getFilterRecords = PivotCategoryFilter::where('category_id', $request->category_id)
            ->orderBy('order', 'asc')->pluck('filter_id')->toArray();

        foreach ($request->filters as $filter) {
            $checkFilter = in_array($filter['id'], $getFilterRecords);

            if (!$checkFilter) {
                return makeResponse('error', 'Filter Record Not Exist In: ' . $filter['id'], 500);
            }
        }
        $products = Product::where('category_id', $request->category_id);

        foreach ($request->filters as $filter) {
            $product = $products->with(['customFieldHasMany'=>function($query) use($filter){
                $query->where('custom_field_id',$filter['id']);
                $query->where('value',$filter['value']);
            }]);
        }

        dd($product->toSql());


        if (sizeof($products) > 0) {
//            $products = $products
        } else {
            return makeResponse('error', 'Record Not Found', 404);
        }


    }
}
