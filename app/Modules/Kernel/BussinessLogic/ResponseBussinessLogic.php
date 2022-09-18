<?php
namespace App\Modules\Kernel\BussinessLogic;

use App\Models\Form;
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

}
