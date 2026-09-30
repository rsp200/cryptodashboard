<?php

use App\Http\Controllers\Api\CoinApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('coins', CoinApiController::class);
