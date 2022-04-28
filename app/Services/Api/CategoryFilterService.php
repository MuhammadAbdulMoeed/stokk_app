<?php


namespace App\Services\Api;


use App\Models\CustomFieldOption;
use App\Models\Filter;
use App\Models\PivotCategoryFilter;
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

            if ($singleFilter->is_active == 1) {
                if ($singleFilter->filter_type == 'pre_included_filter') {
                    $filter = ['name' => $singleFilter->filter_name, 'type' => $singleFilter->field_type,
                        'id' => $singleFilter->id, 'slug' => $singleFilter->slug,
                    ];

                    $getSubCategories = DB::table($singleFilter->field_type)
                        ->where('parent_id', $request->category_id)
                        ->select('name', 'id')
                        ->where('is_active', 1)
                        ->get()->toArray();

                    $filterRecords = $getSubCategories;



                } elseif ($singleFilter->filter_type == 'custom_filter') {

                }

                $custom_fields[] = ['filter' => $filter, 'filter_records' => $filterRecords];

                dd($custom_fields);
            }
        }


    }
}
