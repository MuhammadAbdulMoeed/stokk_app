<?php


namespace App\Services\Admin;


use App\Models\Category;
use App\Models\Filter;
use App\Models\FilterValue;
use Illuminate\Support\Facades\DB;

class FilterService
{
    public function index()
    {
        $data = Filter::all();

        return view('admin.filters.listing', compact('data'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->whereNull('parent_id')->get();
        return view('admin.filters.create', compact('categories'));
    }

    public function save($request)
    {
        DB::beginTransaction();
        try {

            $field_type = null;
            $min = $max = null;
            $filter_name = null;
            if ($request->filter_type = 'pre_included_filter') {
                $field_type = $request->filter;
                $filter_name = $request->filter_name;
            } elseif ($request->filter_type = 'pre_included_filter') {
                $field_type = $request->field_type;
                $filter_name = $request->custom_filter_name;
                if ($field_type == 'price_range') {
                    $min = $request->min;
                    $max = $request->max;
                }

            }

            $filter = Filter::create(['filter_name' => $filter_name,
                'filter_type' => $request->filter_type,
                'field_type' => $field_type, 'min' => $min, 'max' => $max
            ]);

            if($request->field_type == 'simple_select_option' || $request->field_type == 'multi_select_option')
            {
                foreach($request->value as $value)
                {
                    FilterValue::create(['filter_id'=>$filter->id,'name'=>$value]);
                }
            }

            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'Filter Save Successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Filter Record: ' . $e]);
        }
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

    public function changeStatus($request)
    {

    }
}
