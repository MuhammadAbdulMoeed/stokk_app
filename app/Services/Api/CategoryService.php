<?php


namespace App\Services\Api;


use App\Models\Category;

class CategoryService
{
    public function getSubCategory($request)
    {
        $data = array();

        $subCategories =  Category::where('parent_id',$request->category_id)->where('is_active',1)->get();

        foreach($subCategories as $subCategory)
        {
            $data[] = ['name'=>$subCategory->name,'image'=>$subCategory->image,'icon'=>$subCategory->icon,
                'type' => $subCategory->slug];
        }

        return $data;
    }
}
