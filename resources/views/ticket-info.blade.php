@extends("layouts.form")
@section("content")
<div class="container">
    <h2 class="text-center my-4">Ticket info</h2>
    <div class="table-responsive mt-4">
        <table class="table table-dark table-striped table-hover table-bordered text-center">
            <tbody>
                {{-- @foreach ($submissions as $submission) --}}
                <tr>
                    @for ($i = 0; $i < count($submission->form->questions); $i++)
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
                    @endfor
                    <td>
                        {{$submission->created_at}}
                    </td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>
    </div>
</div>
@endsection