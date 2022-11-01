<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Response;
use App\Models\Question;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Modules\Kernel\BussinessLogic\ResponseBussinessLogic;

class ResponseController extends Controller
{

    public $responseBussinessLogic;
    public function __construct(ResponseBussinessLogic $responseBussinessLogic)
    {
        $this->responseBussinessLogic = $responseBussinessLogic;
    }

    public function get_responses($id)
    {
        $form = Form::where("id", $id)->first();
        $questions = Question::where("form_id", $form->id)->orderBy("id")->withTrashed()->get();
        $submissions = Submission::where("form_id", $id)->with("responses")->paginate(25);
        date_default_timezone_set('Africa/Cairo');
        $colors = [
            "success",
            "danger",
            "primary",
            "warning",
        ];

        return view("get-responses", compact("form", "submissions", "questions", "colors"));
    }

    public function save_response(Request $request, $id)
    {
        $validity = $this->responseBussinessLogic->check_form_availability($id);

        if ($validity["error"] && $validity["action"] == "login") {
            return redirect()->route("login");
        } elseif ($validity["error"] && $validity["action"] != "0")
            return view("get-form-error", $validity);


        $err = $this->responseBussinessLogic->validateResponse($request, $id);
        if ($err) return redirect()->route("get_form", ["id" => $id])->with("reponse", $request->response);
        
        try {
            $this->responseBussinessLogic->saveResponse($request, $id);
            $validity["message"] = "You have submited your response.";
            return redirect()->route("get-form-message");
        } catch (\Throwable $th) {
            return view("get-form-error", ["message" => "Something went wrong please try again."]);
        }
    }

    public function export_excel_response($id)
    {
        $responses = $this->responseBussinessLogic->prepareResponsesToExcel($id);
        $this->responseBussinessLogic->createExcel($responses);
    }

    public function reponse_status()
    {
        $data["message"] = "You have submited your response.";
        return view("get-form-error", $data);
    }

    public function getTicket($submissionId)
    {
        $submission = Submission::findOrFail($submissionId);
        return view('ticket', compact('submission'));
    }
}
