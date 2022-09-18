<?php

use Illuminate\Support\Facades\Route;

Route::middleware("auth:web", "role:owner")->group(function () {
    Route::get("dashboard", [App\Http\Controllers\DashboardController::class, "dashboard"])->name("dashboard");
});

Route::get("/", function () {
    return redirect()->route("login");
});