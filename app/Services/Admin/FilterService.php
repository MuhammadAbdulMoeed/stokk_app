<?php


namespace App\Services\Admin;


use App\Models\Category;
use App\Models\CustomFieldOption;
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
        return view('admin.filters.create');
    }

    public function save($request)
    {
        DB::beginTransaction();
        try {

            $field_type = null;
            $min = $max = null;
            $filter_name = null;
            if ($request->filter_type == 'pre_included_filter') {
                $field_type = $request->filter;
                $filter_name = $request->filter_name;
            } elseif ($request->filter_type == 'custom_filter') {

                $field_type = $request->field_type;
                $filter_name = $request->custom_filter_name;
                if ($field_type == 'price_range') {
                    $min = $request->min;
                    $max = $request->max;
                }

            }

            $slug = str_slug($filter_name, "_");


            $filter = Filter::create(['filter_name' => $filter_name,
                'filter_type' => $request->filter_type,
                'field_type' => $field_type, 'min' => $min, 'max' => $max, 'slug' => $slug
            ]);

            if ($request->field_type == 'simple_select_option' || $request->field_type == 'multi_select_option') {
                foreach ($request->value as $value) {
                    FilterValue::create(['filter_id' => $filter->id, 'name' => $value]);
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
        $data = Filter::find($id);

        if ($data) {
            return view('admin.filters.edit', compact('data'));
        } else {
            return redirect()->route('filterListing')->with(['message', 'Record Not Found']);
        }
    }

    public function update($request)
    {
        $data = Filter::find($request->id);
        if ($data) {
            DB::beginTransaction();
            try {

                $field_type = null;
                $min = $max = null;
                $filter_name = null;
                if ($request->filter_type == 'pre_included_filter') {
                    $field_type = $request->filter;
                    $filter_name = $request->filter_name;
                } elseif ($request->filter_type == 'custom_filter') {
                    $field_type = $request->field_type;
                    $filter_name = $request->custom_filter_name;
                    if ($field_type == 'price_range') {
                        $min = $request->min;
                        $max = $request->max;
                    }

                }

                $slug = str_slug($filter_name, "_");


                $filter = $data->update(['filter_name' => $filter_name,
                    'filter_type' => $request->filter_type, 'slug' => $slug,
                    'field_type' => $field_type, 'min' => $min, 'max' => $max
                ]);

                if ($request->field_type == 'simple_select_option' || $request->field_type == 'multi_select_option') {
                    FilterValue::where('filter_id', $filter->id)->delete();
                    foreach ($request->value as $value) {
                        FilterValue::create(['filter_id' => $filter->id, 'name' => $value]);
                    }
                }

                DB::commit();
                return response()->json(['result' => 'success', 'message' => 'Filter Update Successfully']);

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['result' => 'error', 'message' => 'Error in Saving Filter Record: ' . $e]);
            }
        } else {
            return response()->json(['result' => 'error', 'message', 'Record Not Found']);
        }
    }

    public function delete($request)
    {
        $data = Filter::find($request->id);

        if ($data) {
            try {
                $data->delete();
            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Error in Delete Filter: ' . $e]);
            }

            return response()->json(['result' => 'success', 'message' => 'Filter Deleted Successfully']);
        } else {
            return response()->json(['result' => 'success', 'error' => 'Record Not Found']);
        }

    }

    public function changeStatus($request)
    {
        $data = Filter::find($request->id);

        if ($data) {
            try {
                if ($data->is_active == 1) {
                    $isactive = 0;
                } else {
                    $isactive = 1;
                }
                $data->update(['is_active' => $isactive]);

                return response()->json(['result' => 'success', 'message' => 'Status Change']);

            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Error in Change Status: ' . $e]);
            }

        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }
}
