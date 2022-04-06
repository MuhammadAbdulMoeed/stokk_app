<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Services\Admin\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(BrandService $brandService)
    {
        return $brandService->index();
    }

    public function create(BrandService $brandService)
    {
        return $brandService->create();
    }

    public function save(BrandRequest $request,BrandService $brandService)
    {
        return $brandService->save($request);
    }

    public function edit($id,BrandService $brandService)
    {
        return $brandService->edit($id);
    }

    public function update(BrandRequest $request,BrandService $brandService)
    {
        return $brandService->update($request);
    }

    public function delete(Request $request,BrandService $brandService)
    {
        return $brandService->delete($request);
    }

    public function status(Request $request,BrandService $brandService)
    {
        return $brandService->changeStatus($request);
    }

    public function getSubCategory(Request $request,BrandService $brandService)
    {
        return $brandService->getSubCategory($request);
    }

    public function getCategoryBrand(Request $request,BrandService $brandService)
    {
        return $brandService->getCategoryBrand($request);
    }

}
