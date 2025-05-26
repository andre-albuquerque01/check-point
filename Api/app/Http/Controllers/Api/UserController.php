<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Http\Requests\UserUpdateRoleRequest;
use App\Interface\UserControllerInterface;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller implements UserControllerInterface
{
    public function __construct(private UserService $userService) {}
    public function login(AuthRequest $request)
    {
        return $this->userService->login($request->validated());
    }
    public function store(UserRequest $request)
    {
        return $this->userService->store($request->validated());
    }
    public function show()
    {
        return $this->userService->show();
    }
    public function update(UserRequest $request)
    {
        return $this->userService->update($request->validated());
    }
    public function updatePassword(UserUpdatePasswordRequest $request)
    {
        return $this->userService->updatePassword($request->validated());
    }
    public function updatePermission(PermissionRequest $request, string $email)
    {
        return $this->userService->updatePermission($request->validated(), $email);
    }

    public function updateRoleUser(UserUpdateRoleRequest $request, string $id)
    {
        return $this->userService->updateRoleUser($request->validated(), $id);
    }
    public function logout()
    {
        return $this->userService->logout();
    }
}
