<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $auth) {}

    public function register(RegisterRequest $req)
    {
        [$user, $token] = $this->auth->register($req->validated());
        return response()->json(['success'=>true,'data'=>[
            'user'=> new UserResource($user),
            'token'=>$token,
        ]], 201);
    }

    public function login(LoginRequest $req)
    {
        [$user, $token] = $this->auth->login($req->validated());
        return response()->json(['success'=>true,'data'=>[
            'user'=> new UserResource($user),
            'token'=>$token,
        ]]);
    }

    public function me(Request $req)
    {
        return response()->json(['success'=>true,'data'=> new UserResource($req->user())]);
    }

    public function logout(Request $req)
    {
        $req->user()->currentAccessToken()?->delete();
        return response()->json(['success'=>true]);
    }
}
