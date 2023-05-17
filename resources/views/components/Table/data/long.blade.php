<div class="form-group mb-0 px-md-1">
    <label for="">{{$inputSettings->label}}</label>
    <input class="process-input {{$otherClass}} {{$inputSettings->hasError}}" id="exampleInput{{$key}}"
           aria-describedby="{{$key}}Help" type="text"
           {{$inputSettings->regex}} {{$inputSettings->required }} {{$inputSettings->writable }}
           value="{{$inputSettings->value }}" name="{{$inputSettings->name}}"
           placeholder="{{$inputSettings->placeholder}}">
</div>
