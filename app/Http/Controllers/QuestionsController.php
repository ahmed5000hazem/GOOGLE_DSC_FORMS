<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Question;
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
        $form = Form::findOrFail($id);
        $questions = Question::where("form_id", $id)->with("options")->orderBy("order");
        $trashed_questions = Question::onlyTrashed()->count();
        if (request()->query("scope") == "trashed") $questions->onlyTrashed();
        $types = QuestionEnum::cases();
        return view("questions.design-form", [
            "form" => $form,
            "questions" => $questions->get(),
            "question_types" => $types,
            "trashed_questions" => $trashed_questions
        ]);
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
        $values = $this->DesignFormBussinessLogic->validate_format_questions($request->values);
        try {
            if ($values) $this->DesignFormBussinessLogic->save_question_data($values);
            else return redirect()->route("design-form", ["id"=>$values["questions"][0]["form_id"]]);
            
            return redirect()->route("design-form", ["id"=>$values["questions"][0]["form_id"]]);
        } catch (\Throwable $e) {
            return redirect()->route("dashboard")->with("errors", "invalid question format");
        }
    }
    
    public function edit_question($id)
    {
        $question = Question::where("id", $id)->with("options", "form")->first();
        $question_types = collect(QuestionEnum::cases());
        $data = [
            "question" => $question,
            "question_types" => $question_types
        ];
        return view("questions.edit-question", $data);
    }
    
    public function update_questions($id, Request $request)
    {
        $this->DesignFormBussinessLogic->validate_updated_questions($request);
        
        $this->DesignFormBussinessLogic->update_question_data($id, $request);   
        
        // try {
        //     $this->DesignFormBussinessLogic->update_question_data($id, $request);
            
        //     return redirect()->route("design-form", ["id"=>$request->question["form_id"]]);
        // } catch (\Throwable $th) {
        //     return redirect()->route("dashboard")->with("errors", "invalid question format");
        // }
    }

    public function toggle_visibilty($id, Request $request)
    {
        $question = Question::findOrFail($id);
        $question->update(["visible" => $request->visible, "required" => false]);
        return redirect()->back();
    }
    // ======= trash section to be continued
    // public function restore_questions($id)
    // {
    //     $question = Question::withTrashed()->findOrFail($id);
    //     $question->restore();
    //     return redirect()->back();
    // }
    
    // public function trash_all($id)
    // {
    //     Question::where("form_id", $id)->delete();
    //     return redirect()->back();
    // }
    
    // public function restore_all_questions($id)
    // {
    //     $question = Question::withTrashed()->where("form_id", $id);
    //     $question->restore();
    //     return redirect()->route("design-form", ["id" => $id]);
    // }
    // public function delete_questions($id)
    // {
    //     $question = Question::findOrFail($id);
    //     $question->delete();
    //     return redirect()->back();
    // }

    public function hard_delete_questions($id)
    {
        $question = Question::withTrashed()->findOrFail($id);
        $question->responses()->delete();
        $question->options()->delete();
        $question->forceDelete();
        return redirect()->back();
    }
}
