<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

use App\Http\Controllers\QuestionsController;

Route::get("edit/{id}", [FormController::class, "edit"])->name("forms.edit");

Route::get("/create", [FormController::class, "create"])->name("forms.create");

Route::post("/store", [FormController::class, "store"])->name("forms.store");

Route::post("/update/{id}", [FormController::class, "update"])->name("forms.update");

Route::post("/delete/{id}", [FormController::class, "delete"])->name("forms.delete");

Route::get('design-form/{id}', [QuestionsController::class, "design_form"])->name("design-form");

Route::get('{id}/add-questions', [QuestionsController::class, "add_questions"])->name("add-questions");