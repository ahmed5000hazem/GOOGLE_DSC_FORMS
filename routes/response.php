<?php

use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->post("save-response/{id}", [ResponseController::class, "save_response"])->name("save-response");

Route::middleware("auth")->get("get-form-responses/{id}", [ResponseController::class, "get_responses"])->name("get-responses");