@extends("layouts.form-light")
@section('page-title', 'Find Your Ticket')
@section('content')
    <div class="container">
        <div class="row">
            <img class="d-block" style="width:250px;margin:150px auto;" src="/storage/qrcode/{{$submission->id}}.svg" alt="">
        </div>
    </div>
@endsection