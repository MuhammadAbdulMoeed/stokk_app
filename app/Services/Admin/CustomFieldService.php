<?php


namespace App\Services\Admin;


use App\Models\CustomField;
use App\Models\CustomFieldOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class CustomFieldService
{
    public function index()
    {
        $data = CustomField::all();

        return view('admin.custom_fields.listing', compact('data'));
    }

    public function create()
    {
        return view('admin.custom_fields.create');
    }

    public function save($request)
    {
        DB::beginTransaction();
        try {

            $slug = null;
            if(!$request->slug)
            {
                $slug = str_slug($request->name, "_");
            }
            else{
                $slug = $request->slug;

            }

            $field = CustomField::create([
                'name' => $request->name,
                'field_type' => $request->field_type,
                'is_required' => $request->is_required,'slug'=>$slug
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Custom Field Record: ' . $e]);
        }
        try {
            if ($request->field_type == 'simple_select_option' || $request->field_type == 'multi_select_option') {
                foreach ($request->value as $value) {
                    CustomFieldOption::create(['custom_field_id' => $field->id, 'name' => $value]);
                }
            }


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Filter Options: ' . $e]);
        }

        DB::commit();
        return response()->json(['result' => 'success', 'message' => 'Custom Filed Save Successfully']);

    }

    public function edit($id)
    {
        $data = CustomField::find($id);

        if ($data) {
            return view('admin.custom_fields.edit', compact('data'));
        } else {
            return redirect()->route('customFieldsListing')->with(['message', 'Record Not Found']);
        }
    }

    public function update($request)
    {
        $data = CustomField::find($request->id);
        if ($data) {
            DB::beginTransaction();
            try {
                $slug = str_slug($request->name, "_");
                $field = $data->update(['name' => $request->name,
                    'field_type' => $request->field_type,
                    'is_required' => $request->is_required,'slug'=>$slug
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['result' => 'error', 'message' => 'Error in Updating Custom Field: ' . $e]);
            }

            try{

                if ($request->field_type == 'simple_select_option' || $request->field_type == 'multi_select_option') {
                    CustomFieldOption::where('custom_field_id', $data->id)->delete();
                    foreach ($request->value as $value) {
                        CustomFieldOption::create(['custom_field_id' => $data->id, 'name' => $value]);
                    }
                }


            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['result' => 'error', 'message' => 'Error in Updating Custom Field Option: ' . $e]);
            }

            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'Custom Field Update Successfully']);

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
        $data = CustomField::find($request->id);

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
