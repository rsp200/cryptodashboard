<?php

use App\Http\Controllers\CoinController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/coins', [CoinController::class, 'index']);
Route::get('/coins/refresh', [CoinController::class, 'refresh']);
Route::get('/coins/{coin_id}', [CoinController::class, 'show']);
