<?php

namespace App\Interface;

interface CheckInsServiceInterface
{
    public function index();
    public function store(array $data);
    public function show(string $id);
    public function showStaff();
    public function update(array $data, string $id);
    public function destroy(string $id);
}
