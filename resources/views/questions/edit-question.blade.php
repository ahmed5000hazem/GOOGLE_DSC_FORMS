@extends("layouts.app")
@section("content")
<div class="container">
    <h2 class="text-center mt-4">Edit question ( {{$question->question_text}} ) in <a href="{{route("design-form", ["id" => $question->form_id])}}">{{$question->form->name}}</a> form</h2>
    <hr>
    <form action="{{route("update-question", ["id"=>$question->id])}}" method="post" class="p-0">
        @csrf
        <div class="row mt-5 flex-column">
            @component('components.edit-question-formatter')
                @slot('id', $question->id)
                @slot('options', $question_types)
                @slot('selected_option', 0)
                @slot('form_id', $question->form_id)
                @slot("question", $question)
            @endcomponent
        </div>
        @component('components.dynamic-form.btn')
            @slot('btn', 'primary')
            @slot('text', 'save form')
            @slot('classes', 'mb-5');
        @endcomponent
    </form>
</div>
@endsection
@push('end')
<script>
    var selectBoxes = Array.from(document.getElementsByTagName("select"))
    selectBoxes.forEach(box => {
        box.onchange = function () {
            var dataParent = this.getAttribute("data-parent")
            var question_group = document.getElementById(dataParent)
            if (box.value == 2 || box.value == 3) {
                
                var options = question_group.querySelectorAll(".options .opt")
                options.forEach(el => {
                    if (el.getAttribute("data-update") != "1")
                    el.remove()
                })

                question_group.querySelector(".question-input-options").classList.remove("d-none")
                let clone = question_group.querySelector(".main-opt").cloneNode(true)
                clone = finalizeClonedInput(clone, dataParent.replace("question_", ""))
                question_group.querySelector(".options").append(clone)
            } else {
                question_group.querySelector(".question-input-options").classList.add("d-none")
                var options = question_group.querySelectorAll(".options .opt")
                options.forEach(el => {
                    el.remove()
                })
            }
        }
    });
    var addOptionBtns = document.querySelectorAll(".question-input-options .add_question_option")
    addOptionBtns.forEach(btn => {
        btn.onclick = function () {
            var dataParent = this.getAttribute("data-parent")
            var question_group = document.getElementById(dataParent)
            let clone = question_group.querySelector(".main-opt").cloneNode(true)
            clone = finalizeClonedInput(clone, dataParent.replace("question_", ""))
            question_group.querySelector(".options").append(clone)
        }
    })
    function finalizeClonedInput(clone, question_id_number) {
        clone.classList.remove("main-opt", "d-none")
        clone.classList.add("opt", "m-2")
        var cloneInput = clone.querySelector("input")
        cloneInput.removeAttribute("hidden")
        cloneInput.setAttribute("placeholder", "enter opt val")
        cloneInput.setAttribute("name", `new_options[][option_text]`)
        cloneInput.focus()
        return clone
    }
</script>
@endpush
