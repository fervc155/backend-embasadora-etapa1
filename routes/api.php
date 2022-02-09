<?php

use App\Http\Controllers\{AuthController,PermissionsController,RoleController,ClientController,PollStatusController,PollController,QuoteController,UserController,AnswerController};
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




Route::prefix(env('APP_VERSION'))->middleware(['json'])->group(function () {

                Route::get('/ver/{quote}/download', [QuoteController::class, 'download']);

    Route::get('/quotes/{quote}/download/{token}', [QuoteController::class, 'download'])->middleware('auth-get');


    Route::prefix('auth')->group(function(){
        Route::post('register', [AuthController::class, 'register'])->name("register");
        Route::post('login', [AuthController::class, 'login'])->name("login");
        Route::post('logout', [AuthController::class, 'logout'])->name("logout")->middleware('auth');

        Route::post('refresh', [AuthController::class, 'refresh'])->name("logout")->middleware('auth');
        Route::post('check', [AuthController::class, 'check'])->name("logout")->middleware('auth');

        Route::post('recover-password', [AuthController::class, 'recoverPassword'])->name("recoverPassword");
        Route::post('change-password', [AuthController::class, 'changePassword'])->name("changePassword");

    });


    Route::middleware(['auth'])->group(function(){


    Route::prefix('/roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/{rol_id}', [RoleController::class, 'show'])->middleware('findRole');
        Route::post('/', [RoleController::class, 'store']);
        Route::put('/{rol_id}', [RoleController::class, 'update'])->middleware('findRole');
        Route::delete('/{rol_id}', [RoleController::class, 'destroy'])->middleware('findRole');
    });


    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'index']);
        Route::get('/{client}', [ClientController::class, 'show']);
        Route::get('/{client}/answers', [ClientController::class, 'showWithAnswers']);
        Route::post('/', [ClientController::class, 'store']);
        Route::put('/{client}', [ClientController::class, 'update']);
        Route::delete('/{client}', [ClientController::class, 'destroy']);
    });


    Route::prefix('polls')->group(function () {
        Route::get('/', [PollController::class, 'index']);
        Route::get('/{poll}', [PollController::class, 'show']);
        Route::get('/status', [PollStatusController::class, 'index']);
    });
 
    Route::prefix('answers')->group(function () {
        Route::get('/', [AnswerController::class, 'index']);
        Route::get('/{answer}', [AnswerController::class, 'show']);
        Route::post('/', [AnswerController::class, 'store']);
        Route::put('/{answer}', [AnswerController::class, 'update']);
        Route::put('/{answer}/status', [AnswerController::class, 'status']);    
        Route::delete('/{answer}', [AnswerController::class, 'destroy']);
        Route::post('/{answer}/attend', [AnswerController::class, 'attend']);

        Route::get('/status/{pollStatus}/{attend?}', [AnswerController::class, 'indexStatus']);

    });
     Route::prefix('quotes')->group(function () {
        Route::get('/', [QuoteController::class, 'index']);
        Route::get('/{quote}', [QuoteController::class, 'show']);
        Route::post('/', [QuoteController::class, 'store']);
        Route::put('/{quote}', [QuoteController::class, 'update']);
        Route::delete('/{quote}', [QuoteController::class, 'destroy']);

    });

     Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/role/{role}', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::put('/{user}/change-password', [UserController::class, 'changePassword']);
        Route::delete('/{user}', [UserController::class, 'destroy']);

    });


    });




});

