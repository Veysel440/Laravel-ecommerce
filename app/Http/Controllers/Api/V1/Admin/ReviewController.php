<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;

class ReviewController extends Controller {
    public function __construct()
    {
        $this->middleware('permission:reviews.moderate');
    }
    public function moderate(\App\Models\Review $review, \App\Http\Requests\Admin\ReviewModerateRequest $r)
    {
        $review->update(['status'=>$r->status]); return ['success'=>true,'data'=>$review];
    }
}
