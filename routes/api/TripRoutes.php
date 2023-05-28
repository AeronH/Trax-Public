<?php

use App\Http\Controllers\TripController;

Route::get('/all', [TripController::class, 'index']);
Route::post('/store', [TripController::class, 'store']);
