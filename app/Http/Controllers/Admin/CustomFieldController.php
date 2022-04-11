<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomFieldRequest;
use App\Services\Admin\CustomFieldService;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    public function index(CustomFieldService $customFieldService)
    {
        return $customFieldService->index();
    }

    public function create(CustomFieldService $customFieldService)
    {
        return $customFieldService->create();
    }

    public function save(CustomFieldRequest $request, CustomFieldService $customFieldService)
    {
        return $customFieldService->save($request);
    }

    public function edit($id, CustomFieldService $customFieldService)
    {
        return $customFieldService->edit($id);
    }

    public function update(CustomFieldRequest $request, CustomFieldService $customFieldService)
    {
        return $customFieldService->update($request);
    }

    public function delete(Request $request, CustomFieldService $customFieldService)
    {
        return $customFieldService->delete($request);
    }

    public function status(Request $request, CustomFieldService $customFieldService)
    {
        return $customFieldService->changeStatus($request);
    }

    public function getFieldOption(Request $request, CustomFieldService $customFieldService)
    {
        return $customFieldService->getFieldOption($request);
    }
}
