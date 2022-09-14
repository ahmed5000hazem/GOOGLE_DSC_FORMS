<?php

use App\Http\Controllers\QuestionsController;
use Illuminate\Support\Facades\Route;

Route::post("/save-questions", [QuestionsController::class, "save_questions"])->name("save-questions");