<?php

use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->post("save-response/{id}", [ResponseController::class, "save_response"])->name("save-response");