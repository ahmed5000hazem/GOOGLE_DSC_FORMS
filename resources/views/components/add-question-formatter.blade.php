<div id="question_{{$id}}" class="question-qroup col-lg-8 border-bottom pb-3 mt-4">
    <div class="question-inputs d-flex justify-content-between">
        <h4>Q.{{(int) $id + 1}}</h4>
        <input type="hidden" value="{{$form_id}}" name="values[{{$id}}][form_id]">
        <div class="col-auto">
            <input type="text" class="form-control" name="values[{{$id}}][question_text]" placeholder="question text">
        </div>
        <div class="col-auto">
            <input type="number" class="form-control" name="values[{{$id}}][order]" value="{{$id + (int) request()->query("existent_questions") }}" placeholder="question order">
        </div>
        <div class="col-auto">
            <select class="form-select" data-parent="question_{{$id}}" name="values[{{$id}}][question_type]">
                @foreach ($options as $option)
                    <option value="{{$option->value}}" {{$selected_option == $option->value? "selected" : ""}} >{{str_replace("_", " ", $option->name)}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <div class="form-check">
                <label class="form-check-label" for="question_visible">Visible</label>
                <input class="form-check-input" name="values[{{$id}}][visible]" checked type="radio" value="1" id="question_visible">
            </div>
            <div class="form-check">
                <label class="form-check-label" for="question_hidden">Hidden</label>
                <input class="form-check-input" name="values[{{$id}}][visible]" type="radio" value="0" id="question_hidden">
            </div>
        </div>
        <div class="col-auto">
            <div class="form-check">
                <label class="form-check-label" for="question_required">Required</label>
                <input class="form-check-input" name="values[{{$id}}][required]" checked type="radio" value="1" id="question_required">
            </div>
            <div class="form-check">
                <label class="form-check-label" for="question_optional">Optional</label>
                <input class="form-check-input" name="values[{{$id}}][required]" type="radio" value="0" id="question_optional">
            </div>
        </div>
    </div>
    <div class="question-input-options d-none">
        <h3 class="mt-3 text-center text-muted" style="font-size:14px">options</h3>
        <div class="options d-flex flex-wrap">
            <div class="col-3 d-none main-opt">
                <input type="text" class="form-control" name="values[{{$id}}][options][]" hidden>
            </div>
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