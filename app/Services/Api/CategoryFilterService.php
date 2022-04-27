<?php


namespace App\Services\Api;


use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\PivotCategoryField;
use Illuminate\Support\Facades\DB;

class CategoryFilterService
{
    public function getCategoryFilter($request)
    {
        $getFieldRecords = PivotCategoryField::where('category_id', $request->category_id)
            ->where('sub_category_id', $request->sub_category_id)->pluck('custom_field_id')->toArray();

        $fields = CustomField::whereIn('id', $getFieldRecords)->with('customFieldOption')
            ->orderBy('id', 'asc')
            ->get();


        $custom_fields = array();

        foreach ($fields as $singleField) {
            $fieldRecords = array();
            $field = array();

            if ($singleField->is_active == 1) {
                if ($singleField->type == 'pre_included_field') {
                    $field = ['name' => $singleField->name, 'type' => $singleField->field_type, 'slug' => $singleField->slug,
                        'parent_id' => $singleField->parent_id, 'option_id' => $singleField->option_id, 'id' => $singleField->id,
                        'is_required' => $singleField->is_required];

                    $subCategoryFieldRecords = DB::table($singleField->value_taken_from)
                        ->where('category_id', $request->sub_category_id)
                        ->select('name', 'id')
                        ->where('is_active', 1)
                        ->get()->toArray();

                    $categoryFieldRecords = DB::table($singleField->value_taken_from)
                        ->where('category_id',$request->category_id)
                        ->select('name','id')
                        ->where('is_active',1)
                        ->get()->toArray();

                    $fieldRecords = array_merge($subCategoryFieldRecords,$categoryFieldRecords);

                } elseif ($singleField->type == 'custom_field') {
                    $field = ['name' => $singleField->name, 'type' => $singleField->field_type, 'slug' => $singleField->slug,
                        'parent_id' => $singleField->parent_id, 'option_id' => $singleField->option_id, 'id' => $singleField->id,
                        'is_required' => $singleField->is_required];

                    if ($singleField->field_type == 'simple_select_option' || $singleField->field_type == 'multi_select_option') {
                        $fieldRecords = CustomFieldOption::with('relatedFields')
                            ->where('custom_field_id', $singleField->id)
                            ->select('name', 'id')->get();


                    }
                }

                $custom_fields[] = ['field' => $field, 'field_record' => $fieldRecords];


            }
        }

        return makeResponse('success','Filter Retrieve Successfully',200,$custom_fields);
//        return response()->json(['result' => 'success', 'data' => $custom_fields]);
    }
}
