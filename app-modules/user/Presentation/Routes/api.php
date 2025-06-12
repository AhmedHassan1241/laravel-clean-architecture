<?php

use AppModules\User\Presentation\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:sanctum')->group(function () {
Route::prefix('user/')->group(function () {

    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
});
//});

//Route::prefix('user')->middleware('auth:sanctum')->group(function () {
//    Route::get('all', [UserController::class, 'index']);
//    Route::put('/{id}', [UserController::class, 'update']);
//    Route::get('/{id}', [UserController::class, 'show']);
//    Route::delete('/{id}', [UserController::class, 'delete']);
//});
