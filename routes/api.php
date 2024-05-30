<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\User\UserController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::controller(UserController::class)->prefix('/user')->name('user.')->middleware('auth:sanctum')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/detail/{user}', 'show')->name('show');
//    Route::get('/profile', 'profile')->name('profile');
//    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
//    Route::post('/destroy', 'destroy')->name('destroy');
});

