<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function send(Request $r)
    {
        $r->user()->sendEmailVerificationNotification();
        return response()->json(['success'=>true]);
    }
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) return response()->json(['success'=>true]);
        $request->fulfill();
        return response()->json(['success'=>true]);
    }
}
