@if ($visible??false)
<div class="form-group d-none mb-3">
    <label for="{{$id??$name}}" class="form-label {{$label_classes??""}}">{!!$label!!} </label>
    <input id="{{$id??$name}}" @if ($required) required @endif {{$attributes??""}} type="text" class="form-control" placeholder="{{$placeholder??$label}}" value="{{$value??''}}" name="{{$name??''}}">
</div>
@else
<div class="form-group mb-3">
    <label for="{{$id??$name}}" class="form-label {{$label_classes??""}}">{!!$label!!} </label>
    <input id="{{$id??$name}}" @if ($required??false) required @endif {{$attributes??""}} type="text" class="form-control" placeholder="{{$placeholder??$label}}" value="{{$value??''}}" name="{{$name??''}}">
</div>
@endif