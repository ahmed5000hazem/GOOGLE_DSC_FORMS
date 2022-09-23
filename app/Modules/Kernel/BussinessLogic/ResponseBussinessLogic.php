<?php
namespace App\Modules\Kernel\BussinessLogic;

use App\Models\Form;
use App\Models\Question;
use App\Models\Response;
use App\Models\Submission;
use App\Modules\EnumManager\QuestionEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Spatie\SimpleExcel\SimpleExcelWriter as ExcelWriter;

class ResponseBussinessLogic
{    
    public function validateResponse($request, $id)
    {
        $responses = $request->response;
        $errors = [];
        foreach ($responses as $key => $response) {
            if ($response["question_type"] == QuestionEnum::Checkbox->value) {
                if ($response["validation"] == "required" && !isset($request->options[$key])) {
                    $errors[] = ["0"=>"you must choose at least one value"];
                }
                continue;
            }
            $validator = Validator::make($response, [
                "user_id" => "required",
                "question_type" => "required",
                "question_id" => "required",
                "response_text" => "".$response["validation"],
            ]);
            if ($validator->fails()) {
                $err = $validator->errors();
                $errors[] = $err->all();
            }
        }
        return $errors;
    }

    public function saveResponse($request, $form_id)
    {
        $responses = $request->response;
        DB::transaction(function () use($responses, $request, $form_id) {
            $user = auth()->user();
            $submission = Submission::create(["user_id" => $user->id, "form_id" => $form_id]);
            foreach ($responses as $key => $response) {
                $value = collect($response)
                    ->forget(["question_type", "validation"])
                    ->put("submission_id", $submission->id)
                    ->all();
                $form_response = Response::create($value);
                if ($response["question_type"] == QuestionEnum::Checkbox->value) {
                    if (isset($request->options[$key])) {
                        $options = collect($request->options[$key])->map(function ($item) use ($form_response) {
                            return ["response_id" => $form_response->id, "option_id" => $item];
                        })->all();
                        DB::table("option_response")->insert($options);
                    }
                }
            }
        });
    }

    public function check_form_availability($form_id)
    {
        $response = Submission::select("user_id")->where("user_id", auth()->user()->id)->where("form_id", $form_id)->get();
        if ($response->isNotEmpty()) return ["error" => true, "message" => "You have submited your response"];

        $form = Form::findOrFail($form_id);
        if (($form->expires_at && strtotime($form->expires_at) < time())) return ["error" => true, "message" => "Form Expired."];
    }

    public function getResponses($responses)
    {
        $responses_collection = $responses->sortBy("question_id")->groupBy("user_id");
        return $responses_collection;
    }

    public function prepareResponsesToExcel($form_id)
    {
        $questions = Question::where("form_id", $form_id)->orderBy("id")->withTrashed()->get();
        $questions = Question::where("form_id", $form_id)->orderBy("id")->withTrashed()->get();
        $submissions = Submission::where("form_id", $form_id)->with("responses")->get();
        $responses_collection = collect([]);
        foreach ($submissions as $submission) {
            $response_collection = collect([]);
            for ($i = 0; $i < count($questions); $i++){
                $question = strtolower(trim($questions[$i]->question_text));
                if ($submission->responses->where("question_id", $questions[$i]->id)->isNotEmpty()) {
                    $response = (($submission->responses->where("question_id", $questions[$i]->id))->first());
                    if ($response->response_text === null && $response->options){
                        $options_text = "";
                        foreach ($response->options as $option){
                            $options_text.=$option->option_text . "|";
                        }
                        $response_collection->put($question, $options_text);
                    }else {
                        $response_collection->put($question, $response->response_text);
                    }
                } else {
                    $response_collection->put($question, "");
                }
            }
            $response_collection->put("created_at", date($submission->created_at));
            $responses_collection->push($response_collection->all());
        }
        return $responses_collection;
    }

    function createExcel($formated_excel_response)
    {
        $excel = ExcelWriter::streamDownload(public_path('responses.xlsx'), "xlsx");
        $excel->addRows($formated_excel_response);
    }
}
