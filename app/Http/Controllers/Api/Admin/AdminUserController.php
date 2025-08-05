<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserTypeUpdateRequest;
use App\Services\Admin\AdminUserServiceInterface;

class AdminUserController extends Controller
{
    protected $adminUserService;

    public function __construct(AdminUserServiceInterface $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    public function index()
    {
        $users = $this->adminUserService->listAllUsers();
        return ApiResponse::success($users, 'Kullanıcı listesi getirildi.');
    }

    public function updateType(UserTypeUpdateRequest $request, $id)
    {
        $user = $this->adminUserService->updateUserType($id, $request->validated()['userType']);

        return ApiResponse::success($user, 'Kullanıcı tipi başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $this->adminUserService->deleteUser($id);

        return ApiResponse::success(null, 'Kullanıcı başarıyla silindi.');
    }
}
