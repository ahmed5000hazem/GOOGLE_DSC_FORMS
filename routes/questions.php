<?php

use App\Http\Controllers\QuestionsController;
use Illuminate\Support\Facades\Route;

Route::post("/save-questions", [QuestionsController::class, "save_questions"])->name("save-questions");
Route::get("/edit/{id}",[QuestionsController::class, "edit_question"])->name("edit-question");
Route::post("/delete/{id}",[QuestionsController::class, "delete_questions"])->name("delete-question");
Route::post("/restore/{id}",[QuestionsController::class, "restore_questions"])->name("restore-question");
Route::post("/trash-all/{id}",[QuestionsController::class, "trash_all"])->name("trash-all");
Route::post("/restore-all-questions/{id}",[QuestionsController::class, "restore_all_questions"])->name("restore-all-questions");
Route::post("/hard-delete/{id}",[QuestionsController::class, "hard_delete_questions"])->name("hard-delete-question");
Route::post("/update/{id}",[QuestionsController::class, "update_questions"])->name("update-question");
Route::post("/toggle-visibilty/{id}",[QuestionsController::class, "toggle_visibilty"])->name("toggle-visibilty");