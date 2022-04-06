<?php


namespace App\Services\Admin;


use App\Models\AdditionalOption;
use App\Models\Category;

class AdditionalOptionService
{
    public function index()
    {
        $data = AdditionalOption::all();
        return view('admin.additional_options.listing', compact('data'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->where('is_active', 1)->get();
        return view('admin.additional_options.create', compact('categories'));
    }

    public function save($request)
    {
        try {
            AdditionalOption::create($request->except('_token'));

            return response()->json(['result' => 'success', 'message' => 'Additional Option Save Successfully']);
        } catch (\Exception $e) {
            return response()->json(['result' => 'error', 'message' => 'Server Error in Saving Data: ' . $e]);
        }
    }


    public function edit($id)
    {
        $data = AdditionalOption::find($id);

        if ($data) {
            $categories = Category::whereNull('parent_id')->where('is_active', 1)->get();


            return view('admin.additional_options.edit', compact('data', 'categories'));

        } else {
            return redirect()->route('additionalOptionListing')->with('error', 'Record Not Found');
        }
    }

    public function update($request)
    {

        $data = AdditionalOption::find($request->id);
        if ($data) {
            try {

                $data->update($request->except('_token'));

                return response()->json(['result' => 'success', 'message' => 'Additional Option Updated Successfully']);
            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Server Error in Updating Data: ' . $e]);
            }
        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function delete($request)
    {
        $data = AdditionalOption::find($request->id);

        if ($data) {
            try {
                $data->delete();
                return response()->json(['result' => 'success', 'message' => 'Record Deleted']);

            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Error in Delete Data: ' . $e]);
            }

        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function changeStatus($request)
    {
        $data = AdditionalOption::find($request->id);

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

    public function getCategoryAdditionalOption($request)
    {
        $data = AdditionalOption::where('category_id',$request->category_id)->get();

        return response()->json(['result' => 'success', 'data' => $data]);

    }

}
