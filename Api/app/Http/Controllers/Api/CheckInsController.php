<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckInsRequest;
use App\Interface\CheckInsControllerInterface;
use App\Services\CheckInsService;
use Illuminate\Http\Request;

class CheckInsController extends Controller implements CheckInsControllerInterface
{
    public function __construct(private CheckInsService $checkInsService) {}

    public function index()
    {
        return $this->checkInsService->index();
    }
    public function store(CheckInsRequest $request)
    {
        return $this->checkInsService->store($request->validated());
    }
    public function show(string $id)
    {
        return $this->checkInsService->show($id);
    }
    public function showStaff()
    {
        return $this->checkInsService->showStaff();
    }
    public function update(CheckInsRequest $request, string $id)
    {
        return $this->checkInsService->update($request->validated(), $id);
    }
    public function destroy(string $id)
    {
        return $this->checkInsService->destroy($id);
    }
}
