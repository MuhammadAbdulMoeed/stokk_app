<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClothRequest;
use App\Services\Admin\ClothingService;
use Illuminate\Http\Request;

class ClothingTypeController extends Controller
{
    public function index(ClothingService $clothingService)
    {
        return $clothingService->index();
    }

    public function create(ClothingService $clothingService)
    {
        return $clothingService->create();
    }

    public function save(ClothRequest $request, ClothingService $clothingService)
    {
        return $clothingService->save($request);
    }

    public function edit($id, ClothingService $clothingService)
    {
        return $clothingService->edit($id);
    }

    public function update(ClothRequest $request, ClothingService $clothingService)
    {
        return $clothingService->update($request);
    }

    public function delete(Request $request, ClothingService $clothingService)
    {
        return $clothingService->delete($request);
    }

    public function status(Request $request, ClothingService $clothingService)
    {
        return $clothingService->changeStatus($request);
    }

    public function getCategoryCloth(Request $request, ClothingService $clothingService)
    {
        return $clothingService->getCategoryCloth($request);
    }
}
