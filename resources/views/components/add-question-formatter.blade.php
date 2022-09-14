<div id="question_{{$id}}" class="question-qroup col-lg-6 border-bottom pb-3 mt-4">
    <div class="question-inputs d-flex justify-content-between">
        <h4>Q.{{(int) $id + 1}}</h4>
        <input type="hidden" value="{{$form_id}}" name="values[{{$id}}][form_id]">
        <div class="col-auto">
            <input type="text" class="form-control" name="values[{{$id}}][question_text]" placeholder="question">
        </div>
        <div class="col-auto">
            <select class="form-select" data-parent="question_{{$id}}" name="values[{{$id}}][question_type]">
                @foreach ($options as $option)
                    <option value="{{$option->value}}" {{$selected_option == $option->value? "selected" : ""}} >{{str_replace("_", " ", $option->name)}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="question-input-options d-none">
        <h3 class="mt-3 text-center text-muted" style="font-size:14px">options</h3>
        <div class="options d-flex flex-wrap">
            <div class="col-3 d-none main-opt">
                <input type="text" class="form-control" hidden>
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