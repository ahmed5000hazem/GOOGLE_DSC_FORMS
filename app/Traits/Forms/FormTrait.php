<?php
namespace App\Traits\Forms;

use App\Models\Form;

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
}
