<?php

namespace App\Jobs;

use App\Models\Form;
use App\Models\Submission;
use App\Modules\EnumManager\QuestionEnum;
use App\Traits\Responses\MailTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\SimpleExcel\SimpleExcelReader;

class CreateFormFromExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, MailTrait;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $form;
    public $path;
    public $questions;
    public function __construct($path, Form $form, $questions)
    {
        $this->form = $form;
        $this->path = $path;
        $this->questions = $questions;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $form = $this->form;
        $user_email_question = $this->questions->where('question_type', '=', QuestionEnum::Email->value);
        
        // check existence and get id
        if ($user_email_question) $user_email_question = $user_email_question->first()->id;
        SimpleExcelReader::create($this->path)
            ->useHeaders(collect($this->questions)
                ->map(function ($q) {return $q->id;})->all()
                )
            ->getRows()
            ->each(function ($row) use ($form, $user_email_question) {
                $submission = Submission::create(['form_id' => $form->id, 'token' => \Str::random(40)]);
                $row = collect($row);
                $row = $row->map(function ($r, $key) use ($user_email_question, $submission) {
                    $data['question_id'] = $key;
                    $data['response_text'] = $r;
                    if ($data['question_id'] == $user_email_question && $data['response_text']) {
                        $ticket['submission_id'] = $submission->id;
                        $ticket['recipient'] = $data['response_text'];
                        $ticket['subject'] = 'Confirm Submission';
                        $ticket['qrData'] = env('APP_URL', 'gdsc-fu.com').'/get-submission?token='.$submission->token;
                        $this->sendMail($ticket);
                    }
                    return $data;
                });
                $submission->responses()->createMany($row);
            });
    }
}
