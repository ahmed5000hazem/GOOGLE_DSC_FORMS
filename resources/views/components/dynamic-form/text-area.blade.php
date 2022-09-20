@if ($visible??false)
<div class="form-group d-none">
    <label for="{{$id??$name}}" class="form-label {{$label_classes??""}}">{!!$label!!}</label>
    <textarea class="form-control" {{$attributes??""}} id="{{$id??$name}}" rows="3" name="{{$name??''}}">{{$value??''}}</textarea>
</div>
@else
<div class="form-group">
    <label for="{{$id??$name}}" class="form-label {{$label_classes??""}}">{!!$label!!}</label>
    <textarea class="form-control" {{$attributes??""}} id="{{$id??$name}}" rows="3" name="{{$name??''}}">{{$value??''}}</textarea>
</div>
@endif