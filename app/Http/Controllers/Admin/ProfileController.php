<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileSaveRequest;
use App\Services\Admin\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function index(ProfileService $profileService)
    {
        return $profileService->index();
    }

    public function save(ProfileSaveRequest $request,ProfileService $profileService)
    {
        return $profileService->save($request);
    }
}
