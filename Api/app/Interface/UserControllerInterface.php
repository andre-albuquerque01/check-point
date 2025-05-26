<?php

namespace App\Interface;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Http\Requests\UserUpdateRoleRequest;

interface UserControllerInterface
{
    public function login(AuthRequest $request);
    public function store(UserRequest $request);
    public function show();
    public function update(UserRequest $request);
    public function updatePassword(UserUpdatePasswordRequest $request);
    public function updateRoleUser(UserUpdateRoleRequest $request, string $id);
    public function updatePermission(PermissionRequest $request, string $email);
    public function logout();
}
