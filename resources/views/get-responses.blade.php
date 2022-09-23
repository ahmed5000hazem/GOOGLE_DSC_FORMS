@extends("layouts.app")
@section("content")
<div class="container">
    <h2 class="text-center mt-4">Reponses of <a href="{{route("design-form", ["id" => $form->id])}}">{{$form->name}}</a> form</h2>
    <div class="row options">
        <div class="col-auto">
            <h4 class="fs-5"> Questions <span class="badge bg-primary">{{count($questions)}}</span></h4>
        </div>
        <div class="col-auto">
            <h4 class="fs-5"> Responses <span class="badge text-dark bg-info">{{count($responses_collection)}}</span></h4>
        </div>
        
    </div>
    <div class="table-responsive">
        <table class="table table-dark table-striped table-hover table-bordered text-center">
            <thead>
                <tr>
                    @foreach ($questions as $question)
                        <th>{{$question->question_text}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($responses_collection as $responses)
                    @for ($i = 0; $i < count($questions); $i++)
                        @if ($responses->where("question_id", $questions[$i]->id)->isNotEmpty())
                            @php $response = (($responses->where("question_id", $questions[$i]->id))->first()); @endphp
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
                    {{-- @foreach ($responses as $item)
                        @if ($item->response_text == null && $item->options)
                        <td>
                            @foreach ($item->options as $option)
                                <span class=" text-{{$colors[$loop->index % 4]}} @if(count($item->options) >= 3)d-block @endif">{{$option->option_text}}</span>
                            @endforeach
                        </td>
                        @else
                        <td> {{$item->response_text}} </td>
                        @endif
                    @endforeach --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection