<?php

namespace App\Interface;

interface UserServiceInterface
{
    public function login(array $data);
    public function store(array $data);
    public function show();
    public function update(array $data);
    public function updatePassword(array $data);
    public function updateRoleUser(array $data, string $id);
    public function logout();
}
