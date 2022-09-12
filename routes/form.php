<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::get("edit/{id}", [FormController::class, "edit"])->name("forms.edit");

Route::get("/create", [FormController::class, "create"])->name("forms.create");

Route::post("/store", [FormController::class, "store"])->name("forms.store");

Route::post("/update/{id}", [FormController::class, "update"])->name("forms.update");

Route::post("/delete/{id}", [FormController::class, "delete"])->name("forms.delete");
