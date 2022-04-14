<?php


namespace App\Services\Admin;


use App\Models\Category;
use App\Models\CustomField;
use App\Models\Filter;
use App\Models\PivotCategoryField;
use App\Models\PivotCategoryFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryCustomFieldService
{
    public function index()
    {
        $data =  Category::with('categoryFields')->get();
        return view('admin.category_custom_field.listing',compact('data'));
    }

    public function create()
    {

        $categories =  Category::whereNull('parent_id')->get();
        $fields =  CustomField::whereNull('parent_id')->get();

        return view('admin.category_custom_field.create',compact('categories','fields'));
    }

    public function save($request)
    {
        DB::beginTransaction();
        try{

            $check = PivotCategoryField::where('category_id',$request->category_id)->first();

            if(!$check)
            {
                foreach($request->fields as $field)
                {
                    PivotCategoryField::create(['category_id'=>$request->category_id,
                        'custom_field_id'=>$field]);
                }
            }
            else{
                DB::rollBack();
                return response()->json(['result'=>'error','message'=>'Category Field Already Added Edit That']);
            }


            DB::commit();
            return response()->json(['result'=>'success','message'=>'Category Field Save Successfully']);

        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['result'=>'error','message'=>'Error in Saving Category Field: '.$e]);
        }
    }

    public function edit($id)
    {
        $data =  PivotCategoryField::where('category_id',$id)->first();

        if($data)
        {
            $categories =  Category::whereNull('parent_id')->get();
            $fields =  CustomField::all();

            $selectedFilters = PivotCategoryField::where('category_id',$id)->pluck('custom_field_id')->toArray();

            return view('admin.category_custom_field.edit',compact('data','categories','fields','selectedFilters'));
        }
        else{
            return redirect()->route('categoryCustomFieldsListing')->with('error','Record Not Found');
        }
    }

    public function update($request)
    {
        DB::beginTransaction();
        try{
            PivotCategoryField::where('category_id',$request->id)->delete();


            $check = PivotCategoryField::where('category_id',$request->category_id)
                ->where('category_id','!=',$request->id)
                ->first();

            if(!$check)
            {
                foreach($request->fields as $field)
                {
                    PivotCategoryField::create(['category_id'=>$request->category_id,
                        'custom_field_id'=>$field]);
                }
            }
            else{
                DB::rollBack();
                return response()->json(['result'=>'error','message'=>'Category Filter Already Added Edit That']);
            }


//            foreach($request->filters as $filter)
//            {
//                PivotCategoryFilter::create(['category_id'=>$request->category_id,
//                    'filter_id'=>$filter]);
//            }

            DB::commit();
            return response()->json(['result'=>'success','message'=>'Category Fields Updated Successfully']);

        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['result'=>'error','message'=>'Error in Updating Category Fields: '.$e]);
        }
    }

    public function delete($request)
    {
        $data =  PivotCategoryField::where('category_id',$request->category_id)->first();

        if($data)
        {
            try{
                PivotCategoryField::where('category_id',$request->category_id)->delete();
            }
            catch (\Exception $e)
            {
                return response()->json(['result'=>'error','message'=>'Error in Deleting Category Field: '.$e]);

            }


            return response()->json(['result'=>'success','message'=>"Category Field Deleted Successfully"]);

        }
        else{
            return response()->json(['result'=>'error','message'=>'Record Not Found']);
        }
    }

    public function changePosition($id)
    {
        $data =  PivotCategoryField::where('category_id',$id)->orderBy('order','asc')->get();



        if(sizeof($data) > 0 )
        {
            return view('admin.category_custom_field.change_order',compact('data'));
        }
        else{
            return redirect()->route('categoryCustomFieldsListing')->with('error','Record Not Found');
        }
    }

    public function updatePosition($request)
    {
        if (sizeof($request->data) > 0) {
            foreach ($request->data as $key => $filter) {
                $find = PivotCategoryField::find($filter);
                if ($find) {
                    if($key + 1 > 9)
                    {
                        $find->order = $key+1;
                    }
                    else{
//                        $find->order = 0 . $key+1;
                        $find->order = str_pad($key+1, 2, '0', STR_PAD_LEFT);
                    }

                    $find->save();
                }
            }

            return response()->json(['result' => 'success', 'message' => 'Category Field Order Updated']);
        } else {
            return response()->json(['result' => 'error', 'message' => 'Data Not Found']);
        }
    }

}
