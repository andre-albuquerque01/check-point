<?php

use App\Http\Controllers\Api\CheckInsController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('role', RoleController::class)
            ->only(['store', 'update', 'destroy'])
            ->middleware(['ability:admin,editor']);
        Route::apiResource('role', RoleController::class)
            ->only(['index', 'show']);

        Route::apiResource('checkIns', CheckInsController::class)
            ->only(['index', 'show']);
        Route::apiResource('checkIns', CheckInsController::class)
            ->only(['store', 'update', 'destroy'])
            ->middleware(['ability:admin,editor']);
        Route::get('checkIn/showStaff', [CheckInsController::class, 'showStaff']);
    });

    Route::prefix('user')->group(function () {
        Route::post('sessions', [UserController::class, 'login']);
        Route::post('register', [UserController::class, 'store']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', [UserController::class, 'logout']);
            Route::get('me', [UserController::class, 'show']);
            Route::put('update', [UserController::class, 'update']);
            Route::put('update/password', [UserController::class, 'updatePassword']);
            Route::put('update/role/{id}', [UserController::class, 'updateRoleUser'])->middleware(['ability:admin,editor']);
            Route::put('update/permission/{email}', [UserController::class, 'updatePermission'])->middleware(['ability:admin,editor']);
        });
    });
});
