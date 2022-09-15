<?php
namespace App\Modules\Kernel\BussinessLogic;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
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
                $options = $values["questions_options"][$key]->map(function ($item) {
                    return ["option_text" => $item["option_text"]];
                });
                $question->options()->createMany($options->all());
                echo $key;
                echo "<pre>";
                print_r($options);
                echo "</pre>";
            }
        });
    }
}
