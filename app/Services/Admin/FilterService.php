<?php


namespace App\Services\Admin;


use App\Models\Category;
use App\Models\CategoryFilter;

class FilterService
{
    public function index()
    {
        $data =  CategoryFilter::all();

        return view('admin.category_filter.listing',compact('data'));
    }

    public function create()
    {
        $categories =  Category::where('is_active',1)->whereNull('parent_id')->get();
        return view('admin.category_filter.create',compact('categories'));
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

    public function changeStatus($request)
    {

    }
}
