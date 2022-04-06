<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdditionalOptionRequest;
use App\Services\Admin\AdditionalOptionService;
use Illuminate\Http\Request;

class AdditionalOptionController extends Controller
{
    public function index(AdditionalOptionService $additionalOptionService)
    {
        return $additionalOptionService->index();
    }

    public function create(AdditionalOptionService $additionalOptionService)
    {
        return $additionalOptionService->create();
    }

    public function save(AdditionalOptionRequest $request, AdditionalOptionService $additionalOptionService)
    {
        return $additionalOptionService->save($request);
    }

    public function edit($id, AdditionalOptionService $additionalOptionService)
    {
        return $additionalOptionService->edit($id);
    }

    public function update(AdditionalOptionRequest $request, AdditionalOptionService $additionalOptionService)
    {
        return $additionalOptionService->update($request);
    }

    public function delete(Request $request, AdditionalOptionService $additionalOptionService)
    {
        return $additionalOptionService->delete($request);
    }

    public function status(Request $request, AdditionalOptionService $additionalOptionService)
    {
        return $additionalOptionService->changeStatus($request);
    }

    public function getCategoryAdditionalOption(Request $request,AdditionalOptionService $additionalOptionService)
    {
        return $additionalOptionService->getCategoryAdditionalOption($request);
    }
}
