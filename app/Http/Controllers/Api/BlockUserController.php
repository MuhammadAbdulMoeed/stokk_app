<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BlockRequest;
use App\Services\Api\BlockUserService;
use Illuminate\Http\Request;

class BlockUserController extends Controller
{
    public function blockUser(BlockRequest $request,BlockUserService $blockUserService)
    {
        return $blockUserService->blockUser($request);
    }

    public function unBlockUser(BlockRequest $request,BlockUserService $blockUserService)
    {
        return $blockUserService->unBlockUser($request);
    }
}
