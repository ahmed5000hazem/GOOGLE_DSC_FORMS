@if ($visible??false)
<div class="form-group mb-3 d-none">
    <label for="{{$id??$name}}" class="form-label {{$label_classes??""}}">{!!$label!!}</label>
    <input id="{{$id??$name}}" {{$attributes??""}} type="number" class="form-control" placeholder="{{$placeholder??$label}}" value="{{$value??''}}" name="{{$name??''}}">
</div>
@else
<div class="form-group mb-3">
    <label for="{{$id??$name}}" class="form-label {{$label_classes??""}}">{!!$label!!}</label>
    <input id="{{$id??$name}}" {{$attributes??""}} type="number" class="form-control" placeholder="{{$placeholder??$label}}" value="{{$value??''}}" name="{{$name??''}}">
</div>
@endif