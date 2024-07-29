<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('app')->group(function () {
    Route::get('/start', [Controller::class, 'index']);
});

Route::middleware('auth:sanctum')->namespace('Api')->group(function () {
    //Destination
    Route::get('/destination', 'DestinationController@getAll');
    Route::post('/destination/store', 'DestinationController@store');
    Route::post('/destination/approve/{id}', 'DestinationController@approve');
    Route::post('/destination/reject/{id}', 'DestinationController@reject');

    //Tour
    Route::get('/tour', 'TourController@index');
    Route::post('/tour/store', 'TourController@store');
    Route::post('/tour/approve/{id}', 'TourController@approve');
    Route::post('/tour/reactivate/{id}', 'TourController@reactivate');

    //Location
    Route::get('/township', 'LocationController@getTownship');
});
