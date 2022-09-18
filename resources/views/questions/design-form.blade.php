@extends("layouts.app")
@section("content")
<div class="container">
    @if (request()->query("scope") == "trashed")
    <h2 class="text-center mt-4 text-danger">Trash of <a href="{{route("forms.edit", ["id" => $form->id])}}">{{$form->name}}</a> form</h2>
    @else
    <h2 class="text-center mt-4">Manage questions of <a href="{{route("forms.edit", ["id" => $form->id])}}">{{$form->name}}</a> form</h2>
    @endif
    <div class="row options mt-5">
        <div class="col-4 col-lg-3">
            <form action="{{route("add-questions", ["id" => $form->id])}}" class="p-0">
                <div class="input-group mb-3">
                    <button class="btn btn-primary" type="submit">Add N Questions</button>
                    <input type="number" class="form-control" value="{{count($questions)}}" hidden name="existent_questions">
                    <input type="number" class="form-control" placeholder="questions number" name="questions_number">
                </div>
            </form>
        </div>
        @if (request()->query("scope") == "trashed")
            <div class="col-4 col-lg-2">
                <a href="?" class="btn btn-info btn-sm">Back To Form</a>
            </div>
            <div class="col-4 col-lg-2">
                <form action="{{route("restore-all-questions", ["id" => $form->id])}}" class="float-start" method="post">
                    @csrf
                    <button class="btn btn-success btn-sm">Restore All</button>
                </form>
            </div>
        @else
            <div class="col-2 col-lg-2">
                <a href="?scope=trashed" class="btn btn-warning">Go To Trash</a>
            </div>
            <div class="col-2 col-lg-2">
                <form action="{{route("trash-all", ["id" => $form->id])}}" class="float-start" method="post">
                    @csrf
                    <button class="btn btn-danger">Trash All</button>
                </form>
            </div>
            <div class="col-4 col-lg-2">
                <button class="btn btn-info">Responses</button>
            </div>
            <div class="col-4 col-lg-2">
                <a href="{{route("get_form", ["id" => $form->id])}}" class="btn btn-success">Preview</a>
            </div>
            
        @endif
    </div>
    <hr>
    <div class="row my-4">
        <div class="col-auto">
            <h4 class="fs-5"> Questions <span class="badge bg-primary">{{count($questions)}}</span></h4>
        </div>
        <div class="col-auto">
            <h4 class="fs-5"> Trashed <span class="badge bg-danger">{{$trashed_questions}}</span></h4>
        </div>
    </div>
    
    <div class="row">
        <div class="table-responsive">
            <table class="table table-dark table-striped table-hover table-bordered text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Question</th>
                        <th scope="col">Type</th>
                        <th scope="col">Required</th>
                        <th scope="col">Options</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($questions as $question)
                        <tr>
                            <th> {{$question->order??0}} </th>
                            <th> {{$question->id}} </th>
                            <td> {{$question->question_text}} </td>
                            <td> {{str_replace("_", " ", $question_types[$question->question_type]->name)}} </td>
                            @if ($question->required)
                                <td class="text-warning fw-bold"> Required </td>
                            @else
                                <td class="text-success"> optional </td>
                            @endif
                            <td style="width:250px">
                                <ul style="max-width:200px">
                                    @forelse  ($question->options as $option)
                                        @if ($option->option_text)
                                            <li style="font-size: 14px; max-width:170px">{{$option->option_text}}</li>
                                        @endif
                                    @empty
                                        <p class="text-info"  style="max-width:170px"> no options for this question </p>
                                    @endforelse 
                                </ul>
                            </td>
                            <td class="clearfix">
                                <a href="{{route("edit-question", ["id" => $question->id])}}" class="btn btn-info btn-sm me-2 float-start">Edit</a>
                                @if (request()->query("scope") == "trashed")
                                    <form action="{{route("restore-question", ["id" => $question->id])}}" class="float-start" method="post">
                                        @csrf
                                        <button class="btn btn-success btn-sm me-2">Restore</button>
                                    </form>
                                    <form action="{{route("hard-delete-question", ["id" => $question->id])}}" class="float-start" method="post">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Hard Delete</button>
                                    </form>
                                @else
                                    <form action="{{route("delete-question", ["id" => $question->id])}}" class="float-start" method="post">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">Trash</button>
                                    </form>
                                    <form action="{{route("toggle-visibilty", ["id" => $question->id])}}" action="float-start" method="post">
                                        @csrf
                                        <button class="btn btn-{{$question->visible?"primary":"success"}} btn-sm">make {{$question->visible?"Hidden":"Visible"}}</button>
                                        <input class="form-check-input" name="visible" hidden type="text" value="{{$question->visible?"0":"1"}}" id="question_visible">
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        @if (request()->query("scope") == "trashed")
                        <div class="alert-warning alert text-center fs-5 fw-bold">
                            No Questions In Trash
                        </div>
                        @else
                        <div class="alert-warning alert text-center fs-5 fw-bold">
                            This form has no questions yet.
                        </div>
                        @endif
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection