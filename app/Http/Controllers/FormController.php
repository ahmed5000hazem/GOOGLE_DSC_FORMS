<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Option;
use App\Models\Question;
use App\Models\Response;
use App\Modules\EnumManager\QuestionEnum;
use App\Modules\Kernel\BussinessLogic\ResponseBussinessLogic;
use App\Scopes\UserFormScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public $responseBussinessLogic;
    public function __construct(ResponseBussinessLogic $responseBussinessLogic)
    {
        $this->responseBussinessLogic = $responseBussinessLogic;
    }

    public function edit($id)
    {
        $form = Form::findOrFail($id);
        return view("forms.edit", ["form" => $form]);
    }
    public function create()
    {
        return view("forms.create");
    }

    public function store(Request $request)
    {
        $request->validate(["name" => "required"]);

        Form::create([
            "name" => $request->name,
            "description" => $request->description,
            "expires_at" => $request->expires_at,
            "owner_id" => auth()->user()->id,
        ]);

        return redirect()->route("dashboard");
    }
    public function update(Request $request, $id)
    {
        $request->validate(["name" => "required"]);

        $form = Form::findOrFail($id);
        $form->update($request->only("name", "expires_at","description"));
        
        return redirect()->route("dashboard");
    }

    public function get_form($id)
    {
        $validity = $this->responseBussinessLogic->check_form_availability($id);

        if ($validity["error"]??false) 
            return view("get-form-error", $validity);

        $form = Form::withoutGlobalScope(UserFormScope::class)->findOrFail($id);
        $colors = [
            "success",
            "danger",
            "primary",
            "warning",
        ];
        $question_types = QuestionEnum::class;
        $questions = Question::where("form_id", $id)->with("options")->orderBy("order")->get();

        $hidden_questions = $questions->where("visible", 0);
        // dd(count($hidden_questions));
        session(["form_id" => $form->id]);
        return view("make-response", [
            "form" => $form,
            "questions" => $questions,
            "hidden_questions" => $hidden_questions,
            "colors" => $colors,
            "types" => $question_types
        ]);
    }

    public function delete($id)
    {
        $form = Form::where("id", $id)->first();
        $questions = Question::withTrashed()->get();
        $questions = $questions->map(function($item){
            return $item->id;
        })->all();
        $responses = Response::whereIn("question_id", $questions);
        $responsesIds = $responses->get()->map(function($item){ return $item->id; })->all();
        DB::table("option_response")->whereIn("response_id", $responsesIds)->delete();
        $responses->delete();
        Option::whereIn("question_id", $questions)->delete();
        $form->delete();
        return redirect()->route("dashboard");
    }
}
