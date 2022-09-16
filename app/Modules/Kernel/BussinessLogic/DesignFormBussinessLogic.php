<?php
namespace App\Modules\Kernel\BussinessLogic;

use App\Models\Option;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;

class DesignFormBussinessLogic
{
    public function validate_format_questions($values)
    {
        $new_values = [];
        $options_array = [];
        foreach ($values as $index => $inputs){
            if (!$inputs) continue;
            $new_val = [];
            $err = 0;
            foreach ($inputs as $key => $data) {
                if ($data == null && $key != "question_type") { $err = 1; }

                if ($key == "options"){
                    $options = [];
                    foreach ($data as $option) {
                        if ($option){
                            $options_array[] = ["option_text" => $option, "question_index" => $index];
                        }
                    }
                } else {
                    $new_val[$key] = $data;
                }
            }
            if (!$err)
            $new_values[] = $new_val;
        }
        $grouped = collect($options_array)->groupBy("question_index");
        return ["questions" => $new_values, "questions_options" => $grouped->all()];
    }
    public function save_question_data($values)
    {
        DB::transaction(function () use ($values) {
            foreach ($values["questions"] as $key => $value) {
                $question = Question::create($value);
                if (isset($values["questions_options"][$key])){
                    $options = $values["questions_options"][$key]->map(function ($item) {
                        return ["option_text" => $item["option_text"]];
                    });
                    $question->options()->createMany($options->all());
                }
            }
        });
    }

    public function validate_updated_questions($request)
    {
        $validator = Validator::make($request->all(), [
            "question" => "required|array",
            "question.id" => "required",
            "question.form_id" => "required",
            "question.question_text" => "required",
            "question.question_type" => "required",
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with("errors", "invalid question format");
        }
    }

    public function question_formatter($new_options)
    {
        $options = [];
        foreach ($new_options as $new_option) {
            if ($new_option["option_text"]){
                $options[] = $new_option;
            }
        }
        return $options;
    }

    public function update_question_data($question_id, $request)
    {
        $question = Question::find($question_id);
        DB::transaction(function () use ($request, $question) {
            $question->update($request->question);
            if ($request->options){
                foreach ($request->options as $option) {
                    Option::where("id", $option["id"])->update(["option_text" => $option["option_text"]]);
                }
            }
            if($request->new_options){
                $new_options = $this->question_formatter($request->new_options);

                if ($new_options) $question->options()->createMany($new_options);
            }
        });
    }
}
