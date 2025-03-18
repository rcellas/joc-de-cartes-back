<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// programs
Route::get('/programs',[ProgramController::class, 'index']);
Route::get('/programs/{id}',[ProgramController::class, 'show']);
Route::post('/programs',[ProgramController::class, 'store']);
Route::put('/programs/{id}',[ProgramController::class, 'update']);
Route::delete('/programs/{id}',[ProgramController::class, 'destroy']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});


