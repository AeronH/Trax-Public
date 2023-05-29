<?php

use App\Http\Controllers\CarController;

Route::get('/all', [CarController::class, 'index']);
Route::get('/{id}', [CarController::class, 'show']);
Route::post('/store', [CarController::class, 'store']);
Route::delete('/delete/{id}', [CarController::class, 'delete']);


