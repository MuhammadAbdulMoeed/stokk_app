<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProfileRequest;
use App\Services\Api\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function profile(ProfileService $profileService)
    {
        return $profileService->getProfile();
    }

    public function saveProfile(ProfileRequest $request,ProfileService $profileService)
    {
        return $profileService->saveProfile($request);
    }

    public function updateFCMToken(Request $request,ProfileService $profileService)
    {
        return $profileService->updateFCMToken($request);
    }
}
