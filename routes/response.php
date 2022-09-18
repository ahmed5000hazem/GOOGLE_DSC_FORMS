<?php

use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth", "role:owner", "role:normal-user")->post("save-response/{id}", [ResponseController::class, "save_response"])->name("save-response");