@if (isset($question->options))
    @if ($visible??false)
    <div class="d-none">
        <h4>{{$question->question_text}} @if ($question->required) <span class="text-danger ms-1" style="font-size: 13px"> * Required</span> @endif </h4>
        <select class="form-select" aria-label="Default select example">
            <option value="0" selected>...</option>
            @foreach ($question->options as $option)
                <option value="{{$option->id}}">{{$option->option_text}}</option>
            @endforeach
        </select>
    </div>
    @else
    <div>
        <h4>{{$question->question_text}} @if ($question->required) <span class="text-danger ms-1" style="font-size: 13px"> * Required</span> @endif </h4>
        <select class="form-select" aria-label="Default select example">
            <option value="0" selected>...</option>
            @foreach ($question->options as $option)
                <option value="{{$option->id}}" @if (old()) @endif >{{$option->option_text}}</option>
            @endforeach
        </select>
    </div>
    @endif
@endif