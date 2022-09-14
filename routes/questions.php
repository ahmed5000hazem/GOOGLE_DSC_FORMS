<?php

use App\Http\Controllers\QuestionsController;
use Illuminate\Support\Facades\Route;

Route::post("/save-questions", [QuestionsController::class, "saveQuestions"])->name("save-questions");