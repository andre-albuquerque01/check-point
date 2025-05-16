<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Interface\RoleControllerInterface;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller implements RoleControllerInterface
{
    public function __construct(private RoleService $roleService) {}
    public function index()
    {
        return $this->roleService->index();
    }
    public function store(RoleRequest $request)
    {
        return $this->roleService->store($request->validated());
    }
    public function show(string $id)
    {
        return $this->roleService->show($id);
    }
    public function update(RoleRequest $request, string $id)
    {
        return $this->roleService->update($request->validated(), $id);
    }
    public function destroy(string $id)
    {
        return $this->roleService->destroy($id);
    }
}
