<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserLocationRequest;
use App\Services\Api\UserLocationService;
use Illuminate\Http\Request;

class UserLocationController extends Controller
{
    public function save(UserLocationRequest $request,UserLocationService $locationService)
    {
        return $locationService->save($request);
    }
}
