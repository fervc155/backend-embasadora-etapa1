<?php

use App\Http\Controllers\{AuthController,PermissionsController,RoleController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix(env('APP_VERSION'))->group(function () {
    Route::prefix('auth')->group(function(){
        Route::group(['middleware' => ['json.response']], function () {
            Route::post('register', [AuthController::class, 'register'])->name("register");
            Route::post('login', [AuthController::class, 'login'])->name("login");
            Route::post('logout', [AuthController::class, 'logout'])->name("logout")->middleware('auth');

            Route::post('refresh', [AuthController::class, 'refresh'])->name("logout")->middleware('auth');
            Route::post('check', [AuthController::class, 'check'])->name("logout")->middleware('auth');
        });

    });

    Route::prefix('/roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/{rol_id}', [RoleController::class, 'show'])->middleware('findRole');
        Route::post('/', [RoleController::class, 'store']);
        Route::put('/{rol_id}', [RoleController::class, 'update'])->middleware('findRole');
        Route::delete('/{rol_id}', [RoleController::class, 'destroy'])->middleware('findRole');
    });

    Route::prefix('/permissions')->group(function () {
        Route::get('/', [PermissionsController::class, 'index']);
        Route::post('/', [PermissionsController::class, 'store']);
        Route::delete('/{id}', [PermissionsController::class, 'destroy']);
    });



});
