<?php

use App\Http\Controllers\HealthController;
use App\Http\Controllers\ProxyController;
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

Route::get('health',[HealthController::class,"index"]);

//Users (Proxy)
Route::match(['get','post'], '/users', [ProxyController::class, 'users']);
Route::match(['get','put','delete'], '/users/{id}', [ProxyController::class, 'userById']);


// orders (proxy)
Route::match(['get','post'], '/orders', [ProxyController::class, 'orders']);
Route::match(['get','put','delete'], '/orders/{id}', [ProxyController::class, 'orderById']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


