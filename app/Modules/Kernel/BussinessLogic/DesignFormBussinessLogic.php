<?php
namespace App\Modules\Kernel\BussinessLogic;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use App\Models\Option;
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
                            $options_array[] = ["option_text" => $option, "question_id" => $index];
                        }
                    }
                } else {
                    $new_val[$key] = $data;
                }
            }
            if (!$err)
            $new_values[] = $new_val;
        }
        return ["questions" => $new_values, "questions_options" => $options_array];
    }
    public function save_question_data($values)
    {
        // dd($values);
        DB::transaction(function () use ($values) {
            Question::insert($values["questions"]);
            Option::insert($values["questions_options"]);
        });
    }
}
