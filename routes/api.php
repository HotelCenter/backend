<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('me', 'me');
    Route::post('authenticated', 'authenticated');
})->middleware('api')->prefix('auth');

Route::get('hotels/filter/', [HotelController::class, 'getHotelsByFilters']);
Route::get('hotels/rooms/{hotel}', [HotelController::class, 'getRoomsByHotel']);
Route::resource('hotels', HotelController::class);
Route::resource('rooms', RoomController::class);