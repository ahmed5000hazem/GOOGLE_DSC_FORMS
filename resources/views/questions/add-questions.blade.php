@extends("layouts.app")
@section("content")
<div class="container">
    <h2 class="text-center mt-4">Add questions to <a href="{{route("forms.edit", ["id" => $form->id])}}">{{$form->name}}</a> form</h2>
    {{}}
</div>
@endsection