<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(UserService $userService)
    {
        return $userService->index();
    }

    public function create(UserService $userService)
    {
        return $userService->create();
    }

    public function save(UserRequest $request,UserService $userService)
    {
        return $userService->save($request);
    }

    public function edit($id,UserService $userService)
    {
        return $userService->edit($id);
    }

    public function update(UpdateUserRequest $request,UserService $userService)
    {
        return $userService->update($request);
    }

    public function delete(Request $request,UserService $userService)
    {
        return $userService->delete($request);
    }


}
