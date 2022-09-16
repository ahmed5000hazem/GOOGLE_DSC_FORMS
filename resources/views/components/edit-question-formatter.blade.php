<div id="question_{{$id}}" class="question-qroup col-lg-8 border-bottom pb-3 mt-4">
    <div class="question-inputs d-flex justify-content-between">
        <h4>Q.{{(int) $id + 1}}</h4>
        <input type="hidden" value="{{$id}}" name="question[id]">
        <input type="hidden" value="{{$form_id}}" name="question[form_id]">
        <div class="col-auto">
            <input type="text" class="form-control" name="question[question_text]" value="{{$question? $question->question_text:""}}" placeholder="question">
        </div>
        <div class="col-auto">
            <input type="text" class="form-control" name="question[order]" value="{{$question? $question->order:""}}" placeholder="question order">
        </div>
        <div class="col-auto">
            <select class="form-select" data-parent="question_{{$id}}" name="question[question_type]">
                @foreach ($options as $option)
                    <option value="{{$option->value}}" {{($question && $question->question_type == $option->value)? "selected" : ""}} >{{str_replace("_", " ", $option->name)}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <div class="form-check">
                <label class="form-check-label" for="question_visible">Hidden</label>
                <input class="form-check-input" name="question[visible]" type="checkbox" value="0" id="question_visible">
            </div>
        </div>
    </div>
    
    <div class="question-input-options {{!($question->options == [])? "d-none" : ""}}">
        <h3 class="mt-3 text-center text-muted" style="font-size:14px">options</h3>
        <div class="options d-flex flex-wrap">
            <div class="col-3 d-none main-opt">
                <input type="text" class="form-control" name="" hidden>
            </div>
            @foreach ($question->options as $option)
                <div class="col-3 opt m-2" data-update="1">
                    <input type="text" class="form-control" hidden name="options[{{$option->id}}][id]" value="{{$option->id}}" placeholder="enter opt val">
                    <input type="text" class="form-control" name="options[{{$option->id}}][option_text]" value="{{$option->option_text}}" placeholder="enter opt val">
                </div>
            @endforeach
        </div>
        @component('components.dynamic-form.btn')
            @slot('type', 'button')
            @slot('btn', 'success')
            @slot('text', 'add option')
            @slot('classes', 'btn-sm add_question_option');
            @slot('attributes', 'data-parent=question_'.$id);
        @endcomponent
    </div>
</div>