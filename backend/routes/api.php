<?php

use App\Http\Controllers\CoinController;
use App\Http\Controllers\HistoryController;
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

Route::apiResource('coins',CoinController::class)->except('update');
Route::apiResource('coins/history/{gecko_id}',HistoryController::class)->only('index','store');
