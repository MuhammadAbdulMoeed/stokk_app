<?php


namespace App\Services\Admin;


use App\Models\Category;
use App\Models\Size;

class SizeService
{
    public function index()
    {
        $data = Size::all();
        return view('admin.size.listing', compact('data'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->where('is_active', 1)->get();
        return view('admin.size.create', compact('categories'));
    }

    public function save($request)
    {
        try {
            Size::create($request->except('_token'));

            return response()->json(['result' => 'success', 'message' => 'Size Save Successfully']);
        } catch (\Exception $e) {
            return response()->json(['result' => 'error', 'message' => 'Server Error in Saving Data: ' . $e]);
        }
    }


    public function edit($id)
    {
        $data = Size::find($id);

        if ($data) {
            $categories = Category::whereNull('parent_id')->where('is_active', 1)->get();


            return view('admin.size.edit', compact('data', 'categories'));

        } else {
            return redirect()->route('sizeListing')->with('error', 'Record Not Found');
        }
    }

    public function update($request)
    {

        $data = Size::find($request->id);
        if ($data) {
            try {

                $data->update($request->except('_token'));

                return response()->json(['result' => 'success', 'message' => 'Size Updated Successfully']);
            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Server Error in Updating Data: ' . $e]);
            }
        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function delete($request)
    {
        $data = Size::find($request->id);

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
        $data = Size::find($request->id);

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
