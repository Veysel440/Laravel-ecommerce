<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminUserService implements AdminUserServiceInterface
{
    public function listAllUsers()
    {
        try {
            return User::all();
        } catch (\Throwable $e) {
            Log::error('Kullanıcı listesi alınırken hata.', ['error' => $e->getMessage()]);
            throw new Exception('Kullanıcılar getirilemedi.');
        }
    }

    public function updateUserType(int $userId, string $userType)
    {
        try {
            $user = User::findOrFail($userId);
            $user->userType = $userType;
            $user->save();
            return $user;
        } catch (\Throwable $e) {
            Log::error('Kullanıcı tipi güncellenirken hata.', [
                'user_id'   => $userId,
                'user_type' => $userType,
                'error'     => $e->getMessage(),
            ]);
            throw new Exception('Kullanıcı tipi değiştirilemedi.');
        }
    }

    public function deleteUser(int $userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->delete();
            return true;
        } catch (\Throwable $e) {
            Log::error('Kullanıcı silinirken hata.', [
                'user_id' => $userId,
                'error'   => $e->getMessage(),
            ]);
            throw new Exception('Kullanıcı silinemedi.');
        }
    }
}
