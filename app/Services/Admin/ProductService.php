<?php


namespace App\Services\Admin;


use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class ProductService
{
    public function index()
    {
        $data =  Product::all();
        return view('admin.product.listing',compact('data'));
    }

    public function create()
    {
        $categories =  Category::whereNull('parent_id')->where('is_active',1)->get();

        return view('admin.product.create',compact('categories'));
    }

    public function save($request)
    {

    }

    public function edit($id)
    {

    }

    public function update($request)
    {

    }

    public function delete($request)
    {

    }
}
