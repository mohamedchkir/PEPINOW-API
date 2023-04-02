<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('password-reset/{token}', 'updatePassword');
    Route::post('resetPassword', 'resetPassword');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
    Route::put('update', 'update');
})->middleware('auth:api');
// group of middleware
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('roles/detail', [RolesController::class, 'indexWithPermissions']);
    Route::put('/roles/{role}/permissions/{permission}', [RolesController::class, 'updatePermission']);
    Route::put('/users/{user}/role/{role}', [RolesController::class, 'updateRole']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('plants', PlantController::class);
    Route::apiResource('roles', RolesController::class);
    Route::apiResource('permissions', PermissionsController::class);
});
