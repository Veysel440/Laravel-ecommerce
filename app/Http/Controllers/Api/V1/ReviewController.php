<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\{ReviewStoreRequest,ReviewUpdateRequest};
use App\Models\Review;
use App\Services\Review\ReviewService;
use App\Support\ApiResponse;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $svc) {}

    public function store(ReviewStoreRequest $r)
    {
        $rev = $this->svc->create($r->user()->id, (int)$r->product_id, (int)$r->rating, $r->input('body'));
        return ApiResponse::ok($rev, 201);
    }

    public function update(ReviewUpdateRequest $r, Review $review)
    {
        $this->authorize('update', $review);
        $rev = $this->svc->update($review, $r->validated());
        return ApiResponse::ok($rev);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();
        return ApiResponse::ok();
    }
}
