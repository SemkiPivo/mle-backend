<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\User\UserController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::controller(UserController::class)->prefix('/user')->name('user.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/profile', 'show')->name('show');
//    Route::post('/store', 'store')->name('store');
    Route::post('/update', 'update')->name('update');
    Route::post('/destroy', 'destroy')->name('destroy');
});

