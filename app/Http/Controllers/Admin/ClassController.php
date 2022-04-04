<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClassRequest;
use App\Services\Admin\ClassService;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(ClassService $classService)
    {
        return $classService->index();
    }

    public function create(ClassService $classService)
    {
        return $classService->create();
    }

    public function save(ClassRequest $request,ClassService $classService)
    {
        return $classService->save($request);
    }

    public function edit($id,ClassService $classService)
    {
        return $classService->edit($id);
    }

    public function update(ClassRequest $request,ClassService $classService)
    {
        return $classService->update($request);
    }

    public function delete(Request $request,ClassService $classService)
    {
        return $classService->delete($request);
    }

    public function status(Request $request,ClassService $classService)
    {
        return $classService->changeStatus($request);
    }

}
