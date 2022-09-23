<?php
namespace App\Modules\Kernel\BussinessLogic;

use App\Models\Form;
use App\Models\Question;
use App\Models\Response;
use App\Modules\EnumManager\QuestionEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Spatie\SimpleExcel\SimpleExcelReader as ExcelReader;
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
            foreach ($responses as $key => $response) {
                $value = collect($response)->forget(["question_type", "validation"])->all();
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
            $user = auth()->user();
            DB::table("response_user")->insert(["user_id" => $user->id, "form_id" => $form_id]);
        });
    }

    public function check_form_availability($form_id)
    {
        $response = DB::table("response_user")->select("user_id")->where("user_id", auth()->user()->id)->where("form_id", $form_id)->get();
        if ($response->isNotEmpty()) return ["error" => true, "message" => "You have submited your response"];

        $form = Form::find($form_id);
        if (($form->expires_at && strtotime($form->expires_at) < time())) return ["error" => true, "message" => "Form Expired."];

    }

    public function getResponses($questions_ids)
    {
        $responses = Response::whereIn("question_id", $questions_ids->all())->with("options")->paginate(25);
        $responses_collection = $responses->sortBy("question_id")->groupBy("user_id");
        return $responses_collection;
    }

    public function prepareResponsesToExcel($form_id)
    {
        $questions = Question::where("form_id", $form_id)->orderBy("id")->withTrashed()->get();
        $questions_ids = $questions->map(function ($item) {
            return $item->id;
        });

        $responses = Response::whereIn("question_id", $questions_ids->all())->get();
        $responses = $responses->sortBy("question_id")->groupBy("user_id");

        $responses_collection = collect([]);
        foreach ($responses as $user_responses) {
            $response_collection = collect([]);
            for ($i = 0; $i < count($questions); $i++){
                if ($user_responses->where("question_id", $questions[$i]->id)->isNotEmpty()) {
                    $response = (($user_responses->where("question_id", $questions[$i]->id))->first());
                    if ($response->response_text === null && $response->options){
                        $options_text = "";
                        foreach ($response->options as $option){
                            $options_text.=$option->option_text . "|";
                        }
                        $response_collection->put(trim($questions[$i]->question_text), $options_text);
                    }else {
                        $response_collection->put(trim($questions[$i]->question_text), $response->response_text);
                    }
                } else {
                    $response_collection->put(trim($questions[$i]->question_text), "");
                }
            }
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
