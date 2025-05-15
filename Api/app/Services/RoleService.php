<?php

namespace App\Services;

use App\Exceptions\GeneralExceptionCatch;
use App\Http\Resources\RoleResource;
use App\Interface\RoleServiceInterface;
use App\Models\UserRole;

class RoleService implements RoleServiceInterface
{
    public function index()
    {
        try {
            return RoleResource::collection(UserRole::get());
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: index role');
        }
    }
    public function store(array $data)
    {
        try {
            UserRole::create($data);
            return response()->json(['message' => 'success'], 201);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: store role');
        }
    }

    public function show(string $id)
    {
        try {
            $userrole = UserRole::where('id', $id)->first();
            if (!$userrole) {
                return response()->json(['message' => 'role not found'], 404);
            }
            return new RoleResource($userrole);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: show role');
        }
    }

    public function update(array $data, string $id)
    {
        try {
            $userrole = UserRole::where('id', $id)->first();
            if (!$userrole) {
                return response()->json(['message' => 'role not found'], 404);
            }

            $userrole->update($data);
            return response()->json(['message' => 'success'], 201);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: update role');
        }
    }

    public function destroy(string $id)
    {
        try {
            $userrole = UserRole::where('id', $id)->first();
            if (!$userrole) {
                return response()->json(['message' => 'role not found'], 404);
            }
            $userrole->delete();
            return response()->json(['message' => 'success'], 204);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: destroy role');
        }
    }
}
