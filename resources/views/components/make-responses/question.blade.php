<div class="question my-3 d-lg-flex justify-content-{{$justify??"center"}} {{$question_classes??""}}">
    <div class="{{$width_classes??"col-lg-6"}}">
        @if ($question->question_type == 0)
            @component('components.dynamic-form.input')
                @slot('label', $question->question_text)
                @slot('name', str_replace(" ", "_", $question->question_text))
                @slot('placeholder', "")
                @slot('label_classes', "fs-4")
                @slot("attributes", "required")
            @endcomponent
        @elseif($question->question_type == 1)
            @component('components.dynamic-form.text-area')
                @slot('label', $question->question_text)
                @slot('name', str_replace(" ", "_", $question->question_text))
                @slot('placeholder', "")
                @slot('label_classes', "fs-4")
                @slot("attributes", "required")
            @endcomponent
        @elseif($question->question_type == 2)
            @component('components.dynamic-form.checkbox')
                @slot("question", $question)
                @slot('label', $question->question_text)
                @slot('name', str_replace(" ", "_", $question->question_text))
                @slot('placeholder', "")
                @slot('label_classes', "fs-4")
                @slot("attributes", "required")
            @endcomponent
        @elseif($question->question_type == 3)
            @component('components.dynamic-form.radio')
                @slot("question", $question)
                @slot('label', $question->question_text)
                @slot('name', str_replace(" ", "_", $question->question_text))
                @slot('placeholder', "")
                @slot('label_classes', "fs-4")
                @slot("attributes", "required")
            @endcomponent
        @endif
    </div>
</div>