<?php

use Authorization\Http\Controllers\Auth\CodeVerificationController;
use Authorization\Http\Controllers\Auth\ForgotPasswordController;
use Authorization\Http\Controllers\Auth\LoginController;
use Authorization\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::controller(CodeVerificationController::class)->prefix("code")->group(function (){
    Route::post("send", "sendCode");
    Route::post("confirm","confirmCode");
});
Route::controller(RegisterController::class)->prefix("register")->group(function (){
//   Route::post("/check","checkValidation");
   Route::post("/","register");
});
Route::controller(LoginController::class)->prefix("login")->group(function (){
    Route::post("/","login");
});
Route::controller(ForgotPasswordController::class)->prefix("forgot")->group(function (){
    Route::post("/","restore");
});
