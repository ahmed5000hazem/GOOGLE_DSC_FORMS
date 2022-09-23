<div class="question border-3 border-start px-3 border-{{$border_color}} my-4 d-lg-flex justify-content-{{$justify??"center"}} {{$classes??""}}">
    {{-- {!! json_encode(session("reponse")[$question->id]??null) !!} --}}
    {{-- {{ session("reponse")[$question->id]["response_text"]??"" }} --}}
    <div class="{{$width_classes??"col-lg-6"}}">
        <input type="text" hidden name="{{"response[" . $question->id . "][user_id]"}}" value="{{auth()->user()->id}}">
        <input type="text" hidden name="{{"response[" . $question->id . "][question_id]"}}" value="{{$question->id}}">
        <input type="text" hidden name="{{"response[" . $question->id . "][question_type]"}}" value="{{$question->question_type}}">
        <input type="text" hidden name="{{"response[" . $question->id . "][validation]"}}"
            value="{{$question->required?"required":""}}{{$question->question_type == $types::Email->value ?"|email":""}}{{$question->question_type == $types::Numeric->value ?"|numeric":""}}">
        @if ($question->question_type == $types::Short_text->value)
            @component('components.dynamic-form.input')
                @slot('label', $question->required? $question->question_text . '<span class="text-danger ms-1" style="font-size: 13px"> * Required</span>':$question->question_text)
                @slot('name', 'response[' . $question->id . '][response_text]')
                @slot('placeholder', "")
                @slot('label_classes', "fs-4")
                @slot("required", $question->required)
                @slot("visible", !$question->visible)
                @slot('value', session("reponse")[$question->id]["response_text"]??"")
            @endcomponent
        @elseif($question->question_type == $types::Long_text->value)
            @component('components.dynamic-form.text-area')
                @slot('label', $question->required? $question->question_text . '<span class="text-danger ms-1" style="font-size: 13px"> * Required</span>':$question->question_text)
                @slot('name', 'response[' . $question->id . '][response_text]')
                @slot('placeholder', "")
                @slot('label_classes', "fs-4")
                @slot("attributes", $question->required?"required":"")
                @slot("visible", !$question->visible)
                @slot('value', session("reponse")[$question->id]["response_text"]??"")
            @endcomponent
        @elseif($question->question_type == $types::Checkbox->value)
            @component('components.dynamic-form.checkbox')
                @slot("question", $question)
                @slot('label', $question->question_text)
                @slot('placeholder', "")
                @slot("visible", !$question->visible)
                @slot('label_classes', "fs-4")
            @endcomponent
        @elseif($question->question_type == $types::Radio_button->value)
            @component('components.dynamic-form.radio')
                @slot("question", $question)
                @slot('label', $question->question_text)
                @slot('name', 'response[' . $question->id . '][response_text]')
                @slot('placeholder', "")
                @slot('label_classes', "fs-4")
                @slot("visible", !$question->visible)
                @slot("required", $question->required)
            @endcomponent
        @elseif($question->question_type == $types::Email->value)
            @component('components.dynamic-form.email')
                @slot('label', $question->required? $question->question_text . '<span class="text-danger ms-1" style="font-size: 13px"> * Required</span>':$question->question_text)
                @slot('name', 'response[' . $question->id . '][response_text]')
                @slot('placeholder', "")
                @slot('label_classes', "fs-4")
                @slot("attributes", $question->required?"required":"")
                @slot("visible", !$question->visible)
                @slot('value', session("reponse")[$question->id]["response_text"]??auth()->user()->email)
            @endcomponent
        @elseif($question->question_type == $types::Numeric->value)
            @component('components.dynamic-form.number')
                @slot('label', $question->required? $question->question_text . '<span class="text-danger ms-1" style="font-size: 13px"> * Required</span>':$question->question_text)
                @slot('name', 'response[' . $question->id . '][response_text]')
                @slot('placeholder', "")
                @slot('label_classes', "fs-4")
                @slot("attributes", $question->required?"required":"")
                @slot("visible", !$question->visible)
                @slot('value', session("reponse")[$question->id]["response_text"]??"")
            @endcomponent
        @endif
    </div>
</div>