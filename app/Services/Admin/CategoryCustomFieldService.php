<?php


namespace App\Services\Admin;


use App\Models\Category;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\Filter;
use App\Models\PivotCategoryField;
use App\Models\PivotCategoryFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryCustomFieldService
{
    public function index()
    {
        $data = array();
        $pivotTableRecords = PivotCategoryField::all();

        foreach ($pivotTableRecords as $key => $pivotTableRecord) {

//            $data [$category->category->name][] = ['category_name'=>$category->category->name,
//                'sub_cat_name'=>isset($category->subCategory) ? $category->subCategory->name:null,
//                'field_name'=>$category->field->name,'cat_id'=>$category->id];

            if ($pivotTableRecord->subCategory) {
                $data[$pivotTableRecord->category->name . '-' . $pivotTableRecord->category->id . '-' . $pivotTableRecord->subCategory->name][] = $pivotTableRecord->field->name;
            } else {
                $data[$pivotTableRecord->category->name . '-' . $pivotTableRecord->category->id][] = $pivotTableRecord->field->name;

            }


        }


        return view('admin.category_custom_field.listing', compact('data'));
    }

    public function create()
    {

        $categories = Category::whereNull('parent_id')->get();
        $fields = CustomField::whereNull('parent_id')->get();

        return view('admin.category_custom_field.create', compact('categories', 'fields'));
    }

    public function save($request)
    {
        DB::beginTransaction();
        try {

            $check = PivotCategoryField::where('category_id', $request->category_id)->first();

            if (!$check) {
                foreach ($request->fields as $field) {
                    PivotCategoryField::create(['category_id' => $request->category_id,
                        'sub_category_id' => $request->sub_category_id,
                        'custom_field_id' => $field]);
                }
            } else {
                DB::rollBack();
                return response()->json(['result' => 'error', 'message' => 'Category Field Already Added Edit That']);
            }


            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'Category Field Save Successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Saving Category Field: ' . $e]);
        }
    }

    public function edit($id)
    {
        $data = PivotCategoryField::where('category_id', $id)->first();

        if ($data) {
            $categories = Category::whereNull('parent_id')->get();
            $fields = CustomField::all();

            $selectedFilters = PivotCategoryField::where('category_id', $id)->pluck('custom_field_id')->toArray();

            $subCategories =  Category::where('parent_id',$data->category->id)->get();

            return view('admin.category_custom_field.edit', compact('data', 'categories', 'fields', 'selectedFilters','subCategories'));
        } else {
            return redirect()->route('categoryCustomFieldsListing')->with('error', 'Record Not Found');
        }
    }

    public function update($request)
    {
        DB::beginTransaction();
        try {
            PivotCategoryField::where('category_id', $request->id)->delete();


            $check = PivotCategoryField::where('category_id', $request->category_id)
                ->where('category_id', '!=', $request->id)
                ->first();

            if (!$check) {
                foreach ($request->fields as $field) {
                    PivotCategoryField::create(['category_id' => $request->category_id,
                        'sub_category_id' => $request->sub_category_id,
                        'custom_field_id' => $field]);
                }
            } else {
                DB::rollBack();
                return response()->json(['result' => 'error', 'message' => 'Category Filter Already Added Edit That']);
            }


//            foreach($request->filters as $filter)
//            {
//                PivotCategoryFilter::create(['category_id'=>$request->category_id,
//                    'filter_id'=>$filter]);
//            }

            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'Category Fields Updated Successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['result' => 'error', 'message' => 'Error in Updating Category Fields: ' . $e]);
        }
    }

    public function delete($request)
    {
        $data = PivotCategoryField::where('category_id', $request->category_id)->first();

        if ($data) {
            try {
                PivotCategoryField::where('category_id', $request->category_id)->delete();
            } catch (\Exception $e) {
                return response()->json(['result' => 'error', 'message' => 'Error in Deleting Category Field: ' . $e]);

            }


            return response()->json(['result' => 'success', 'message' => "Category Field Deleted Successfully"]);

        } else {
            return response()->json(['result' => 'error', 'message' => 'Record Not Found']);
        }
    }

    public function changePosition($id)
    {
        $data = PivotCategoryField::where('category_id', $id)->orderBy('order', 'asc')->get();


        if (sizeof($data) > 0) {
            return view('admin.category_custom_field.change_order', compact('data'));
        } else {
            return redirect()->route('categoryCustomFieldsListing')->with('error', 'Record Not Found');
        }
    }

    public function updatePosition($request)
    {
        if (sizeof($request->data) > 0) {
            foreach ($request->data as $key => $filter) {
                $find = PivotCategoryField::find($filter);
                if ($find) {
                    if ($key + 1 > 9) {
                        $find->order = $key + 1;
                    } else {
//                        $find->order = 0 . $key+1;
                        $find->order = str_pad($key + 1, 2, '0', STR_PAD_LEFT);
                    }

                    $find->save();
                }
            }

            return response()->json(['result' => 'success', 'message' => 'Category Field Order Updated']);
        } else {
            return response()->json(['result' => 'error', 'message' => 'Data Not Found']);
        }
    }

    public function getCategoryField($request)
    {
        $getFieldRecords = PivotCategoryField::where('category_id', $request->category_id)
            ->where('sub_category_id', $request->sub_category_id)->pluck('custom_field_id')->toArray();


        $fields = CustomField::whereIn('id',$getFieldRecords)->with('customFieldOption')
            ->orderBy('id','asc')
            ->get();

        $custom_fields = array();

        foreach($fields as $singleField)
        {
            $fieldRecords =  array();
            $field =  array();

            if($singleField->is_active == 1)
            {
                if($singleField->type == 'pre_included_field')
                {
                    $field = ['name'=>$singleField->name,'type'=>$singleField->field_type,'slug'=>$singleField->slug,
                        'parent_id'=>$singleField->parent_id,'option_id'=>$singleField->option_id,'id'=>$singleField->id,
                        'is_required'=>$singleField->is_required];
                    $fieldRecords = DB::table($singleField->value_taken_from)
                        ->where('category_id', $request->sub_category_id)
                        ->select('name','id')
                        ->where('is_active',1)
                        ->get();
                }
                elseif($singleField->type == 'custom_field')
                {
                    $field = ['name'=>$singleField->name,'type'=>$singleField->field_type,'slug'=>$singleField->slug,
                        'parent_id'=>$singleField->parent_id,'option_id'=>$singleField->option_id,'id'=>$singleField->id,
                        'is_required'=>$singleField->is_required];
                    if($singleField->type == 'simple_select_option' || $singleField->type == 'multi_select_option')
                    {
                        $fieldRecords = CustomFieldOption::where('custom_field_id',$singleField->id)
                            ->select('name','id')->get();
                    }
                }

                $custom_fields[] = ['field'=>$field,'field_record'=>$fieldRecords];


            }
        }

        return response()->json(['result'=>'success','data'=>$custom_fields]);

    }

}
