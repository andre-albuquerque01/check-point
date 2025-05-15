<?php

namespace App\Services;

use App\Exceptions\GeneralExceptionCatch;
use App\Http\Resources\CheckInsResource;
use App\Interface\CheckInsServiceInterface;
use App\Models\CheckIns;
use Illuminate\Support\Facades\Auth;

class CheckInsService implements CheckInsServiceInterface
{
    public function index()
    {
        try {
            return CheckInsResource::collection(CheckIns::with('user')->get());
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: index checkins');
        }
    }
    public function store(array $data)
    {
        try {
            CheckIns::create($data);
            return response()->json(['message' => 'success'], 201);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: store checkins');
        }
    }

    public function show(string $id)
    {
        try {
            $checkins = CheckIns::with('user')->where('id', $id)->first();
            if (!$checkins) {
                return response()->json(['message' => 'checkins not found'], 404);
            }
            return new CheckInsResource($checkins);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: show checkins');
        }
    }

    public function showStaff()
    {
        try {
            $checkins = CheckIns::with('user')->where('user_id', Auth::user()->id)->get();
            if (!$checkins) {
                return response()->json(['message' => 'checkins not found'], 404);
            }
            return CheckInsResource::collection($checkins);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: show staff checkins');
        }
    }

    public function update(array $data, string $id)
    {
        try {
            $checkins = CheckIns::where('id', $id)->first();
            if (!$checkins) {
                return response()->json(['message' => 'checkins not found'], 404);
            }

            $checkins->update($data);
            return response()->json(['message' => 'success'], 201);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: update checkins');
        }
    }

    public function destroy(string $id)
    {
        try {
            $checkins = CheckIns::where('id', $id)->first();
            if (!$checkins) {
                return response()->json(['message' => 'checkins not found'], 404);
            }
            $checkins->delete();
            return response()->json(['message' => 'success'], 204);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: destroy checkins');
        }
    }
}
