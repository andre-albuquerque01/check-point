<?php

namespace App\Service;

use App\Exceptions\GeneralExceptionCatch;
use App\Http\Resources\UserResource;
use App\Interface\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function __construct(private Request $request) {}

    public function login(array $data)
    {
        try {
            if (!Auth::attempt($data)) {
                return response()->json(['message', 'E-mail or password invalid'], 401);
            }

            $token = $this->request->user()->createToken('JesusIsKingOfKings', ['*'], now()->addHours(2))->plainTextToken;
            return response()->json(['token' => $token], 200);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: login');
        }
    }

    public function logout()
    {
        try {
            $this->request->user()->currentAccessToken()->delete();
            return response()->json(['message', 'success'], 204);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: login');
        }
    }

    public function store(array $data)
    {
        try {
            $data['password'] = Hash::make($data['password']);
            User::create($data);

            return response()->json(['message' => 'success'], 201);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: user create');
        }
    }

    public function show()
    {
        try {
            return new UserResource(User::with('role')->findOrFail(Auth::user()->id)->first());
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: user show');
        }
    }

    public function update(array $data)
    {
        try {
            $user = User::where('id', Auth::user()->id)->first();
            if (!$user) {
                return response()->json(['message' => 'user not found'], 404);
            }
            if (!Hash::check($data['password'], $user->password)) {
                return response()->json(['message' => 'password incorrect'], 401);
            }
            $data['password'] = $user->password;

            $user->update($data);
            return response()->json(['message', 'success'], 201);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: user update');
        }
    }

    public function updatePassword(array $data)
    {
        try {
            $user = User::where('id', Auth::user()->id)->first();
            if (!$user) {
                return response()->json(['message' => 'user not found'], 404);
            }
            if (!Hash::check($data['password_old'], $user->password)) {
                return response()->json(['message' => 'password incorrect'], 401);
            }

            $user->update($data);
            return response()->json(['message', 'success'], 201);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: user update password');
        }
    }
    public function updateRoleUser(array $data, string $id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (!$user) {
                return response()->json(['message' => 'user not found'], 404);
            }

            $user->update($data);
            return response()->json(['message', 'success'], 201);
        } catch (\Exception $e) {
            throw new GeneralExceptionCatch('Error: user update role');
        }
    }
}
