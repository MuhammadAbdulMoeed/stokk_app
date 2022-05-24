<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostReviewRequest;
use App\Services\Api\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function saveReview(PostReviewRequest $request,ReviewService $reviewService)
    {
        return $reviewService->save($request);
    }
}
