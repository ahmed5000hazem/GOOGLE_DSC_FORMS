@extends("layouts.app")
@section("content")
<div class="container">
    <h2 class="text-center mt-4">Reponses of <a href="{{route("design-form", ["id" => $form->id])}}">{{$form->name}}</a> form</h2>
</div>
@endsection