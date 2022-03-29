<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilterRequest;
use App\Services\Admin\FilterService;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    //
    public function index(FilterService $filterService)
    {
        return $filterService->index();
    }

    public function create(FilterService $filterService)
    {
        return $filterService->create();
    }

    public function save(FilterRequest $request, FilterService $filterService)
    {
        return $filterService->save($request);
    }

    public function edit($id, FilterService $filterService)
    {
        return $filterService->edit($id);
    }

    public function update(FilterRequest $request, FilterService $filterService)
    {
        return $filterService->update($request);
    }

    public function delete(Request $request, FilterService $filterService)
    {
        return $filterService->delete($request);
    }

    public function status(Request $request, FilterService $filterService)
    {
        return $filterService->changeStatus($request);
    }
}
