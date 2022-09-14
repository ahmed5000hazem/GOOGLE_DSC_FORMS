<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Modules\EnumManager\QuestionEnum;
class QuestionsController extends Controller
{
    public function design_form($id)
    {
        $form = Form::find($id);
        return view("questions.design-form", ["form" => $form]);
    }
    
    public function add_questions(Request $request, $id)
    {
        $questions_number = $request->query("questions_number")? $request->query("questions_number") : 0;
        $question_types = collect(QuestionEnum::cases());
        return view("questions.add-questions", [
            "questions_number" => $questions_number,
            "form" => Form::find($id),
            "question_types" => $question_types
        ]);
    }

    public function saveQuestions(Request $request)
    {
        dd($request);
    }
}
