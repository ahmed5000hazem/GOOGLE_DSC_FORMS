@extends("layouts.form")
@section("content")
<div class="container">
    <h2 class="text-center mt-4"> <span class="text-primary d-block my-3"> Ticket Info </span> booked at {{$submission->created_at}}</h2>
    <div class="row options my-4 align-items-center">
        <div class="col-auto">
            <h4 class="fs-5"> Questions <span class="badge bg-primary">{{count($submission->form->questions)}}</span></h4>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover table-bordered text-center">
            <tbody>
                @for ($i = 0; $i < count($submission->form->questions); $i++)
                <tr>
                    <th class="text-info">{{$submission->form->questions[$i]->question_text}}</th>
                    @if ($submission->responses->where("question_id", $submission->form->questions[$i]->id)->isNotEmpty())
                    @php $response = (($submission->responses->where("question_id", $submission->form->questions[$i]->id))->first()); @endphp
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
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
@endsection