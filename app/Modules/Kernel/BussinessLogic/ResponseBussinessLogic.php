<?php
namespace App\Modules\Kernel\BussinessLogic;

use App\Models\Response;
use App\Modules\EnumManager\QuestionEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    public function saveResponse($request)
    {
        $responses = $request->response;
        DB::transaction(function () use($responses, $request) {
            foreach ($responses as $key => $response) {
                $value = collect($response)->forget(["question_type", "validation"])->all();
    
                $response = Response::create($value);
                if ($response["question_type"] == QuestionEnum::Checkbox->value) {
                    if (isset($request->options[$key])) {
                        $options = collect($request->options[$key])->map(function ($item) use ($response) {
                            return ["response_id" => 5, "option_id" => $item];
                        })->all();
                        DB::table("option_response")->insert($options);
                    }
                }
            }
        });
    }
}
