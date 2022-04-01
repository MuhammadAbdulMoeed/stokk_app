<?php


namespace App\Services\Admin;


use App\Models\Category;
use App\Models\Filter;
use App\Models\PivotCategoryFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryFilterService
{
    public function index()
    {
        $data =  Category::with('categoryFilters')->get();
        return view('admin.category_filter.listing',compact('data'));
    }

    public function create()
    {

        $categories =  Category::whereNull('parent_id')->get();
        $filters =  Filter::all();

        return view('admin.category_filter.create',compact('categories','filters'));
    }

    public function save($request)
    {
        DB::beginTransaction();
        try{

            $check = PivotCategoryFilter::where('category_id',$request->category_id)->first();

            if(!$check)
            {
                foreach($request->filters as $filter)
                {
                    PivotCategoryFilter::create(['category_id'=>$request->category_id,
                        'filter_id'=>$filter]);
                }
            }
            else{
                DB::rollBack();
                return response()->json(['result'=>'error','message'=>'Category Filter Already Added Edit That']);
            }


            DB::commit();
            return response()->json(['result'=>'success','message'=>'Category Filters Save Successfully']);

        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['result'=>'error','message'=>'Error in Saving Category Filters: '.$e]);
        }
    }

    public function edit($id)
    {
        $data =  PivotCategoryFilter::where('category_id',$id)->first();

        if($data)
        {
            $categories =  Category::whereNull('parent_id')->get();
            $filters =  Filter::all();

            $selectedFilters = PivotCategoryFilter::where('category_id',$id)->pluck('filter_id')->toArray();

            return view('admin.category_filter.edit',compact('data','categories','filters','selectedFilters'));
        }
        else{
            return redirect()->route('categoryFilterListing')->with('error','Record Not Found');
        }
    }

    public function update($request)
    {
        DB::beginTransaction();
        try{
            PivotCategoryFilter::where('category_id',$request->id)->delete();


            $check = PivotCategoryFilter::where('category_id',$request->category_id)
                ->where('category_id','!=',$request->id)
                ->first();

            if(!$check)
            {
                foreach($request->filters as $filter)
                {
                    PivotCategoryFilter::create(['category_id'=>$request->category_id,
                        'filter_id'=>$filter]);
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
            return response()->json(['result'=>'success','message'=>'Category Filters Updated Successfully']);

        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['result'=>'error','message'=>'Error in Updating Category Filters: '.$e]);
        }
    }

    public function delete($request)
    {
        $data =  PivotCategoryFilter::where('category_id',$request->category_id)->first();

        if($data)
        {
            try{
                PivotCategoryFilter::where('category_id',$request->category_id)->delete();
            }
            catch (\Exception $e)
            {
                return response()->json(['result'=>'error','message'=>'Error in Deleting Category Filters: '.$e]);

            }


            return response()->json(['result'=>'success','message'=>"Category Filters Deleted Successfully"]);

        }
        else{
            return response()->json(['result'=>'error','message'=>'Record Not Found']);
        }
    }

    public function changePosition($id)
    {
        $data =  PivotCategoryFilter::where('category_id',$id)->orderBy('order','asc')->get();


        if(sizeof($data) > 0 )
        {
            return view('admin.category_filter.change_order',compact('data'));
        }
        else{
            return redirect()->route('categoryFilterListing')->with('error','Record Not Found');
        }
    }

    public function updatePosition($request)
    {
        if (sizeof($request->data) > 0) {
            foreach ($request->data as $key => $filter) {
                $find = PivotCategoryFilter::find($filter);
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

            return response()->json(['result' => 'success', 'message' => 'Category Filter Order Updated']);
        } else {
            return response()->json(['result' => 'error', 'message' => 'Data Not Found']);
        }
    }

}
