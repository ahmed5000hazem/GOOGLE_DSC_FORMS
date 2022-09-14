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
        if ($request->query("questions_number"))
            $questions_number = $request->query("questions_number");
        else 
            return redirect()->back();
        $question_types = collect(QuestionEnum::cases());
        return view("questions.add-questions", [
            "questions_number" => $questions_number,
            "form" => Form::find($id),
            "question_types" => $question_types
        ]);
    }

    public function save_questions(Request $request)
    {
        $values = $this->remove_nulls($request->values);
        dd($values);
    }

    private function remove_nulls($values)
    {
        $new_values = [];
        foreach ($values as $inputs){
            if (!$inputs) continue;
            $new_val = [];
            $err = 0;
            foreach ($inputs as $key => $data) {
                if ($data == null && $key != "question_type") {$err = 1;}
                $new_val[$key] = $data;
                if ($key == "options"){
                    $options = [];
                    foreach ($data as $option) {
                        if ($option){
                            $options[] = $option;
                        }
                    }
                    $new_val["options"] = $options;
                }
            }
            if (!$err)
            $new_values[] = $new_val;
        }
        return $new_values;
    }
}
