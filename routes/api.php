<?php

use App\Http\Controllers\ClassifiedController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [UserController::class, 'registration']);
Route::post('/auth', [UserController::class, 'authorization']);

Route::get('/classifieds', [ClassifiedController::class, 'index']);
Route::get('/classifieds/{classified}', [ClassifiedController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/user/classifieds', [ClassifiedController::class, 'userClassifieds']);

    Route::post('/classifieds', [ClassifiedController::class, 'store']);
    Route::patch('/classifieds/{classified}', [ClassifiedController::class, 'update']);
    Route::delete('/classifieds/{classified}', [ClassifiedController::class, 'destroy']);
});
