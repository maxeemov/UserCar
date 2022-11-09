<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\UserCarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;

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

Route::group(['middleware' => ['cors', 'json.response']], function () {
    // public routes
    Route::post('/login', [ApiAuthController::class, 'login'])->name('login.api');
    Route::post('/register', [ApiAuthController::class, 'store'])->name('register.api');
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout.api');
});

//Admin routes
Route::group(['middleware' => ['auth:api', 'admin']], function () {
    //Car actions
    Route::resource('/cars',CarController::class)->except(['create', 'edit']);

    //User actions
    Route::resource('/users',UserController::class)->except(['create', 'edit', 'store']);

    //UserCar actions
    Route::resource('/users_cars',UserCarController::class)->only(['index', 'store']);
    Route::put('/users_cars/detach_user/{id}',[UserCarController::class, 'detachUser']);
    Route::put('/users_cars/detach_car/{id}',[UserCarController::class, 'detachCar']);
});
