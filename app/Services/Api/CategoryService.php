<?php


namespace App\Services\Api;


use App\Models\Category;
use App\Models\Product;
use App\Traits\ProductFetchTrait;

class CategoryService
{

    use ProductFetchTrait;


    public function getAllCategories()
    {
        $categories = Category::select('id', 'name', 'icon', 'image','slug as type')->where('is_active', 1)->whereNull('parent_id')->get();

        return $categories;
    }


    public function getSubCategory($request)
    {
        $data = array();

        $subCategories =  Category::where('parent_id',$request->category_id)->where('is_active',1)->get();

        foreach($subCategories as $subCategory)
        {
            $data[] = ['name'=>$subCategory->name,'image'=>$subCategory->image,
                'icon'=>$subCategory->icon,
                'type' => $subCategory->slug,'id'=>(string)$subCategory->id,
                'parent_id'=>$subCategory->parent_id];
        }

        return $data;
    }

    public function searchCategory($request)
    {
        $data = Category::where('name', 'like', '%' . $request->name . '%')
            ->whereNull('parent_id')
            ->where('is_active', 1)
            ->get();

        $categories = array();

        if (sizeof($data) > 0) {
            foreach ($data as $key => $category) {
                $categories[] = ['name' => $category->name, 'id' => $category->id, 'images' => $category->image,
                    'icon' => $category->icon];
            }

            return makeResponse('success', 'Category Found Successfully', 200, $categories);
        } else {
            return makeResponse('error', 'Record Not Found', 404);
        }
    }

    public function getSubCategoryProduct($request)
    {
        $products = array();
        $findCategory = Category::where('id', $request->category_id)
            ->whereNull('parent_id')
            ->where('is_active', 1)
            ->first();

        if ($findCategory) {
            $findSubCategory = Category::where('id', $request->sub_category_id)
                ->whereNotNull('parent_id')
                ->where('is_active', 1)
                ->first();

            if (!$findSubCategory) {
                return makeResponse('error', 'Sub Category Not Found', 404);
            } else {
                if ($findSubCategory->parent_id != $request->category_id) {
                    return makeResponse('error', 'This SubCategory does not belong to Category', '200');
                }

                $productsList = Product::where('sub_category_id',$request->sub_category_id)
                    ->where('is_active',1)
                    ->get();

                if(sizeof($productsList) > 0)
                {
                    $products = $this->fetchProduct($productsList);
                    return makeResponse('success', 'Record Found', 200, $products);
                }
                else{
                    return makeResponse('error', 'Record Not Found', 404);
                }
            }
        } else {
            return makeResponse('error', 'Category Not Found', 404);
        }

    }


}
