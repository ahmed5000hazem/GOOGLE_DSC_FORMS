@extends("layouts.app")
@section("content")
<div class="container">
    <h2 class="text-center mt-4">Reponses of <a href="{{route("design-form", ["id" => $form->id])}}">{{$form->name}}</a> form</h2>
    <div class="row options my-4 align-items-center">
        <div class="col-auto">
            <h4 class="fs-5"> Questions <span class="badge bg-primary">{{count($questions)}}</span></h4>
        </div>
        <div class="col-auto">
            <h4 class="fs-5"> Responses <span class="badge text-dark bg-info">{{count($submissions)}}</span></h4>
        </div>
        <div class="col-auto">
            <a href="{{route("export-excel-response", ["id" => $form->id])}}" class="btn btn-primary">Export as Excel</a>
        </div>
        
    </div>
    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover table-bordered text-center">
            <thead>
                <tr>
                    @foreach ($questions as $question)
                        <th>{{$question->question_text}}</th>
                    @endforeach
                    <th>at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submissions as $submission)
                <tr>
                    @for ($i = 0; $i < count($questions); $i++)
                    @if ($submission->responses->where("question_id", $questions[$i]->id)->isNotEmpty())
                    @php $response = (($submission->responses->where("question_id", $questions[$i]->id))->first()); @endphp
                    @if ($response->response_text == null && $response->options)
                        <td>
                            @foreach ($response->options as $option)
                                <span class=" text-{{$colors[$loop->index % 4]}} @if(count($response->options) >= 3)d-block @endif">{{$option->option_text}}</span>
                            @endforeach
                        </td>
                        @else
                        <td> {{$response->response_text}} </td>
                        @endif
                    @else
                    <td class="text-warning fw-bold" title="no data because the question doesnot have any responses in database so cant render it's response">No Data</td>
                    @endif
                    @endfor
                    <td>
                        {{$submission->created_at}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $submissions->links("vendor.pagination.bootstrap-5") }}
</div>
@endsection