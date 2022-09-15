<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Modules\EnumManager\QuestionEnum;

use App\Modules\Kernel\BussinessLogic\DesignFormBussinessLogic;

class QuestionsController extends Controller
{
    private $DesignFormBussinessLogic;
    
    public function __construct(DesignFormBussinessLogic $DesignFormBussinessLogic) {
        $this->DesignFormBussinessLogic = $DesignFormBussinessLogic;
    }

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
        try {
            $values = $this->DesignFormBussinessLogic->validate_format_questions($request->values);
            $this->DesignFormBussinessLogic->save_question_data();
        } catch (\Throwable $e) {
            return redirect()->route("dashboard")->with("errors", "invalid request format");
        }
    }
}
