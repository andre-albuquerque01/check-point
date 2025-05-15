<?php

namespace App\Interface;

use App\Http\Requests\CheckInsRequest;

interface CheckInsControllerInterface
{
    public function index();
    public function store(CheckInsRequest $request);
    public function show(string $id);
    public function showStaff();
    public function update(CheckInsRequest $request, string $id);
    public function destroy(string $id);
}
