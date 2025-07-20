<?php

namespace App\Services\Admin;

interface AdminUserServiceInterface
{
    public function listAllUsers();
    public function updateUserType(int $userId, string $userType);
    public function deleteUser(int $userId);

}
