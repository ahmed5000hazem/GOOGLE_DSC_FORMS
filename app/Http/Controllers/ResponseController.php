<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Response;
use App\Models\Question;
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
        $questions_ids = $questions->map(function ($item) {
            return $item->id;
        });

        $responses_collection = $this->responseBussinessLogic->getResponses($questions_ids);

        $colors = [
            "success",
            "danger",
            "primary",
            "warning",
        ];

        return view("get-responses", compact("form", "responses_collection", "questions", "colors"));
    }

    public function save_response(Request $request, $id)
    {
        $validity = $this->responseBussinessLogic->check_form_availability($id);

        if ($validity["error"] ?? false)
            return view("get-form-error", $validity);


        $err = $this->responseBussinessLogic->validateResponse($request, $id);
        if ($err) return redirect()->route("get_form", ["id" => $id])->with("reponse", $request->response);
        try {
            $this->responseBussinessLogic->saveResponse($request, $id);
            return redirect()->route("get_form", ["id" => $id]);
        } catch (\Throwable $th) {
            return view("get-form-error", ["message" => "Something went wrong please try again."]);
        }
    }
}
