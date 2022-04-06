<?php


namespace App\Services\Admin;


use App\Models\Category;
use App\Models\ItemCondition;

class ItemConditionService
{
    public function index()
    {
        $data = ItemCondition::all();
        return view('admin.item_condition.listing', compact('data'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->where('is_active',1)->get();
        return view('admin.item_condition.create', compact('categories'));
    }

    public function save($request)
    {
        try {
            ItemCondition::create($request->except('_token'));

            return response()->json(['result' => 'success', 'message' => 'Item Condition Save Successfully']);
        } catch (\Exception $e) {
            return response()->json(['result' => 'error', 'message' => 'Server Error in Saving Data: ' . $e]);
        }
    }


    public function edit($id)
    {
        $data = ItemCondition::find($id);

        if ($data) {
            $categories = Category::whereNull('parent_id')->where('is_active',1)->get();



//            $subCategory = Category::
            return view('admin.item_condition.edit', compact( 'data','categories'));

        } else {
            return redirect()->route('itemConditionListing')->with('error', 'Record Not Found');
//            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function update($request)
    {

        $data = ItemCondition::find($request->id);
        if ($data) {
            try {

                $data->update($request->except('_token') );

                return response()->json(['result' => 'success', 'message' => 'Item Condition Updated Successfully']);
            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Server Error in Updating Data: ' . $e]);
            }
        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function delete($request)
    {
        $data = ItemCondition::find($request->id);

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
        $data = ItemCondition::find($request->id);

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

    public function getCategoryItemConditon($request){
        $data = ItemCondition::where('category_id',$request->category_id)->get();

        return response()->json(['result' => 'success', 'data' => $data]);
    }


}
