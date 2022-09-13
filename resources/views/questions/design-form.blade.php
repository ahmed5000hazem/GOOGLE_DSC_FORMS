@extends("layouts.app")
@section("content")
<div class="container">
    <h2 class="text-center mt-4">Manage questions of <a href="{{route("forms.edit", ["id" => $form->id])}}">{{$form->name}}</a> form</h2>
    <div class="row options mt-5">
        <form action="{{route("add-questions", ["id" => $form->id])}}" class="p-0">
            <div class="col-4 col-lg-3">
                <div class="input-group mb-3">
                    <button class="btn btn-primary" type="submit">Add N Questions</button>
                    <input type="number" class="form-control" placeholder="questions number" name="questions_number">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection