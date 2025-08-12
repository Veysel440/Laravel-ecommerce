<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'name'  => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role'  => 'customer',
        ]);
        $user->assignRole('customer');
        $token = $user->createToken('api')->plainTextToken;
        return [$user, $token];
    }

    public function login(array $data): array
    {
        if (!Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])) {
            throw ValidationException::withMessages(['email'=>'Invalid credentials']);
        }
        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('api')->plainTextToken;
        return [$user, $token];
    }
}
