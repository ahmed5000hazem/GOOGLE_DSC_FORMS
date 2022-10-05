<?php

use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Route;


Route::middleware("auth")->group(function () {
    Route::get("get-form-responses/{id}", [ResponseController::class, "get_responses"])->name("get-responses");
    
    Route::get("export-excel-response/{id}", [ResponseController::class, "export_excel_response"])->name("export-excel-response");
});
    
Route::post("save-response/{id}", [ResponseController::class, "save_response"])->name("save-response");
Route::get("get-form-error", [ResponseController::class, "reponse_status"])->name("get-form-message");