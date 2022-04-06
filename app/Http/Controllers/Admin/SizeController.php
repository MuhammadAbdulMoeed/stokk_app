<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SizeRequest;
use App\Services\Admin\SizeService;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index(SizeService $sizeService)
    {
        return $sizeService->index();
    }

    public function create(SizeService $sizeService)
    {
        return $sizeService->create();
    }

    public function save(SizeRequest $request, SizeService $sizeService)
    {
        return $sizeService->save($request);
    }

    public function edit($id, SizeService $sizeService)
    {
        return $sizeService->edit($id);
    }

    public function update(SizeRequest $request, SizeService $sizeService)
    {
        return $sizeService->update($request);
    }

    public function delete(Request $request, SizeService $sizeService)
    {
        return $sizeService->delete($request);
    }

    public function status(Request $request, SizeService $sizeService)
    {
        return $sizeService->changeStatus($request);
    }

    public function getCategorySize(Request $request,SizeService  $sizeService)
    {
        return $sizeService->getCategorySize($request);
    }

}
