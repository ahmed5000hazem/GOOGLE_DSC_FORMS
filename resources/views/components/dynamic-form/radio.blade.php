@if ($question->options)
    <h4>{{$question->question_text}} @if ($question->required) <span class="text-danger ms-1" style="font-size: 13px"> * Required</span> @endif </h4>
    @foreach ($question->options as $option)
        @if ($option->option_text)
            <div class="form-check {{count($question->options) > 5 ?"form-check-inline mt-3":""}} ">
                <input @if ($loop->first) {{$question->required?"required":""}} @endif class="form-check-input" type="radio" name="{{"response[" . $question->id . "][response_text]"}}" value="{{$option->option_text}}" id="{{str_replace(" ", "_", $option->option_text).$option->id}}">
                <label class="form-check-label" for="{{str_replace(" ", "_", $option->option_text).$option->id}}">{{$option->option_text}}</label>
            </div>
        @endif
    @endforeach
@else
    <div class="form-check">
        <h4>{{$question->question_text??""}}</h4>
        <input class="form-check-input" type="radio" name="{{$name??""}}" value="" id="{{$id??$name}}">
        <label class="form-check-label" for="{{$id??$name}}">{{$label??""}}</label>
    </div>
@endif