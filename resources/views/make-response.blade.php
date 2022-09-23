@extends("layouts.form")
@section('page-title', $form->name)
@section("content")
<div class="container">
    @component('components.make-responses.header')
        @slot('form', $form)
        @slot('questions', $questions)
    @endcomponent
    @if (!($form->expires_at && strtotime($form->expires_at) < time()))
    <form action="{{route("save-response", ["id" => $form->id])}}" method="post">
        @csrf
        @forelse ($questions as $question)
            @component('components.make-responses.question')
                @slot('question', $question)
                @slot("border_color", $colors[($loop->index) % 4])
                @slot("types", $types)
                @slot("form", $form)
            @endcomponent
        @empty
            <div class="alert alert-warning">No Questions Yet</div>
        @endforelse
        @if ($questions->isNotEmpty())
        <div class="col-lg-6 m-auto my-5">
            @component('components.dynamic-form.btn')
                @slot('btn', 'success')
            @endcomponent
        </div>
        @endif
    </form>
    @endif
</div>
@endsection