<?php

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


