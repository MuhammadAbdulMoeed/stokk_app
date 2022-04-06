<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ItemConditionRequest;
use App\Services\Admin\ItemConditionService;
use Illuminate\Http\Request;

class ItemConditionController extends Controller
{
    public function index(ItemConditionService $itemConditionService)
    {
        return $itemConditionService->index();
    }

    public function create(ItemConditionService $itemConditionService)
    {
        return $itemConditionService->create();
    }

    public function save(ItemConditionRequest $request,ItemConditionService $itemConditionService)
    {
        return $itemConditionService->save($request);
    }

    public function edit($id,ItemConditionService $itemConditionService)
    {
        return $itemConditionService->edit($id);
    }

    public function update(ItemConditionRequest $request,ItemConditionService $itemConditionService)
    {
        return $itemConditionService->update($request);
    }

    public function delete(Request $request,ItemConditionService $itemConditionService)
    {
        return $itemConditionService->delete($request);
    }

    public function status(Request $request,ItemConditionService $itemConditionService)
    {
        return $itemConditionService->changeStatus($request);
    }

    public function getSubCategory(Request $request,ItemConditionService $itemConditionService)
    {
        return $itemConditionService->getSubCategory($request);
    }

    public function getCategoryItemConditon(Request $request,ItemConditionService $itemConditionService)
    {
        return $itemConditionService->getCategoryItemConditon($request);
    }

}
