<div class="form-group">
    <label for="{{$id??$name}}" class="form-label">{{$label}}</label>
    <textarea class="form-control" id="{{$id??$name}}" rows="3" name="{{$name??''}}">{{$value??''}}</textarea>
</div>