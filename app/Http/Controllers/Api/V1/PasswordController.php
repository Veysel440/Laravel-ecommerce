<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function sendResetLink(Request $r)
    {
        $r->validate(['email'=>['required','email']]);
        $status = Password::sendResetLink($r->only('email'));
        return response()->json(['success'=> $status === Password::RESET_LINK_SENT]);
    }

    public function reset(Request $r)
    {
        $r->validate([
            'token'=>['required'],'email'=>['required','email'],
            'password'=>['required','min:8','confirmed'],
        ]);
        $status = Password::reset(
            $r->only('email','password','password_confirmation','token'),
            function ($user, $password) {
                $user->forceFill(['password'=>bcrypt($password),'remember_token'=>Str::random(60)])->save();
                event(new PasswordReset($user));
            }
        );
        return response()->json(['success'=> $status === Password::PASSWORD_RESET]);
    }
}
