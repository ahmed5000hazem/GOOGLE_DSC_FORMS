<?php

namespace App\Http\Controllers;

use App\Jobs\CreateFormFromExcel;
use App\Models\Form;
use App\Models\Option;
use App\Models\Question;
use App\Models\Response;
use App\Modules\EnumManager\QuestionEnum;
use App\Modules\Kernel\BussinessLogic\ResponseBussinessLogic;
use App\Scopes\UserFormScope;
use App\Traits\Forms\FormTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    use FormTrait;
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
        $request->validate(["name" => "required", "auth" => "required", "multi_submit" => "required"]);

        Form::create([
            "name" => $request->name,
            "description" => $request->description,
            "expires_at" => $request->expires_at,
            "auth" => $request->auth,
            "multi_submit" => $request->multi_submit,
            "owner_id" => auth()->user()->id,
        ]);

        return redirect()->route("dashboard");
    }
    public function update(Request $request, $id)
    {
        $request->validate(["name" => "required", "auth" => "required", "multi_submit" => "required"]);

        $form = Form::findOrFail($id);
        $form->update($request->only("name", "expires_at", "description", "auth", "multi_submit"));
        
        return redirect()->route("dashboard");
    }

    public function get_form($id)
    {
        $validity = $this->responseBussinessLogic->check_form_availability($id);
        
        if ($validity["error"] && $validity["action"] == "login") {
            return redirect()->route("login");
        } elseif ($validity["error"] && $validity["action"] != "0")
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
        session(["form_id" => $form->id]);
        return view("make-response", [
            "form" => $form,
            "questions" => $questions,
            "hidden_questions" => $hidden_questions,
            "colors" => $colors,
            "types" => $question_types
        ]);
    }
    // empty_only is truthy falsy value to empty form or delete form itself after make it empty
    public function delete($id)
    {
        $form = Form::where("id", $id)->first();
        $this->clearFormData($form);
        $form->delete();
        return redirect()->route("dashboard");
    }
    
    public function importFromExcel($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_submissions' => ['required', 'mimes:xls,xlsx']
        ]);
        if ($validator->fails()){
            return redirect()->back();
        }
        $form = Form::find($id);
        $clean = $this->clearFormData($form);

        if ($clean) { // check if clean then store the file
            $request->form_submissions->storeAs('form_submissions', $id . '.' . $request->form_submissions->extension(), 'public');
        }

        CreateFormFromExcel::dispatch($form);

    }
}
