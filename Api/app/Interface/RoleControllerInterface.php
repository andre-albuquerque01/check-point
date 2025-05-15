<?php

namespace App\Interface;

use App\Http\Requests\RoleRequest;

interface RoleControllerInterface
{
    public function index();
    public function store(RoleRequest $request);
    public function show(string $id);
    public function update(RoleRequest $request, string $id);
    public function destroy(string $id);
}
