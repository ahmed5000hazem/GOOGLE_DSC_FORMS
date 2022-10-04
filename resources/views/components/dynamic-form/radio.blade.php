@if (isset($question->options))
    @if ($visible??false)
        <div class="d-none">
            <h4>{{$question->question_text}} @if ($question->required) <span class="text-danger ms-1" style="font-size: 13px"> * Required</span> @endif </h4>
            @foreach ($question->options as $option)
                @if ($option->option_text)
                    <div class="form-check {{count($question->options) > 5 ?"form-check-inline mt-3":""}} ">
                        <input @if ($loop->first) {{$question->required?"required":""}} @endif class="form-check-input" type="radio" name="{{"response[" . $question->id . "][response_text]"}}" value="{{$option->option_text}}" id="{{str_replace(" ", "_", $option->option_text).$option->id}}">
                        <label class="form-check-label" for="{{str_replace(" ", "_", $option->option_text).$option->id}}">{{$option->option_text}}</label>
                    </div>
                @endif
            @endforeach
        </div>
    @else
    <div>
        <h4>{{$question->question_text}} @if ($question->required) <span class="text-danger ms-1" style="font-size: 13px"> * Required</span> @endif </h4>
        @foreach ($question->options as $option)
            @if ($option->option_text)
                <div class="form-check {{count($question->options) > 5 ?"form-check-inline mt-3":""}} ">
                    <input @if ($loop->first) {{$question->required?"required":""}} @endif class="form-check-input" type="radio" name="{{"response[" . $question->id . "][response_text]"}}" value="{{$option->option_text}}" id="{{str_replace(" ", "_", $option->option_text).$option->id}}">
                    <label class="form-check-label" for="{{str_replace(" ", "_", $option->option_text).$option->id}}">{{$option->option_text}}</label>
                </div>
            @endif
        @endforeach
    </div>
    @endif
@else
    <div class="form-check form-check-inline">
        <h4>{{$question->question_text??""}}</h4>
        <input class="form-check-input" {{$attributes??""}} type="radio" name="{{$name??""}}" value="{{$value??''}}" id="{{$id??$name}}">
        <label class="form-check-label {{$labelClasses??''}}"  for="{{$id??$name}}">{{$label??""}}</label>
    </div>
@endif