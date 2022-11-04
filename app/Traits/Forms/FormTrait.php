<?php
namespace App\Traits\Forms;

use App\Jobs\CreateFormFromExcel;
use App\Jobs\SendTicketViaMail;
use App\Models\Form;
use App\Models\Submission;
use App\Modules\EnumManager\QuestionEnum;
use Spatie\SimpleExcel\SimpleExcelReader;

/**
 * 
 */
// helper trait for forms
trait FormTrait
{
    public function deleteFormResponses(Form $form)
    {
        return $form->responses()->delete();
    }

    public function deleteFormQuestions(Form $form)
    {
        return $form->questions()->forceDelete();
    }
    
    public function deleteFormOptions(Form $form)
    {
        return $form->options()->withTrashedParents()->delete();
    }
    
    public function deleteFormSubmissions(Form $form)
    {
        return $form->submissions()->delete();
    }
    public function clearFormData(Form $form)
    {
        try {
            $this->deleteFormResponses($form);
            $this->deleteFormOptions($form);
            $this->deleteFormQuestions($form);
            $this->deleteFormSubmissions($form);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    private function createQuestionsFromExcelHeaders($path, Form $form)
    {

        $headers = collect($this->excelHandelerService->readHeaders($path));
        $headers = $headers->map(function ($header) {
            $type = QuestionEnum::Short_text->value;
            if (\Str::contains(strtolower($header), 'mail')) {
                $type = QuestionEnum::Email->value;
            }
            $question['question_text'] = $header;
            $question['question_type'] = $type;
            return $question;
        });
        return $form->questions()->createMany($headers);
    }

    public function createResponsesFromExcelRows($path, Form $form)
    {
        $questions = $this->createQuestionsFromExcelHeaders($path, $form);
        
        CreateFormFromExcel::dispatch($path, $form, $questions);

        return $questions;
    }
}
