<?php

use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// restaurants
Route::get('/restaurants',[RestaurantController::class, 'index']);
Route::get('/restaurants/{id}',[RestaurantController::class, 'show']);
Route::post('/restaurants',[RestaurantController::class, 'store']);
Route::put('/restaurants/{id}',[RestaurantController::class, 'update']);
Route::delete('/restaurants/{id}',[RestaurantController::class, 'destroy']);

// programs
Route::get('/programs',[ProgramController::class, 'index']);
Route::get('/programs/{id}',[ProgramController::class, 'show']);
Route::post('/programs',[ProgramController::class, 'store']);
Route::put('/programs/{id}',[ProgramController::class, 'update']);
Route::delete('/programs/{id}',[ProgramController::class, 'destroy']);


