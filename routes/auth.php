<?php

use Illuminate\Support\Facades\Route;

// authentication
Route::middleware("guest")->group(function () {
    Route::get("register", [App\Http\Controllers\Auth\AuthController::class, "register_form"])->name("register_form");
    Route::post("register", [App\Http\Controllers\Auth\AuthController::class, "register"])->name("register");
    Route::get("login", [App\Http\Controllers\Auth\AuthController::class, "login_form"])->name("login_form");
    Route::post("login", [App\Http\Controllers\Auth\AuthController::class, "login"])->name("login");
    Route::post("logout", [App\Http\Controllers\Auth\AuthController::class, "logout"])->name("logout");
});