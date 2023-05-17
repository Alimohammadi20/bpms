<div class="form-group  px-md-2 {{$inputSettings->hidden}}">
    <label for="">{{$inputSettings->label}}</label>
    <input class="process-input {{$otherClass}} {{$inputSettings->hasError}} {{$inputSettings->hidden}}"
           id="exampleInput{{$inputSettings->id}}"
           aria-describedby="{{$inputSettings->id}}Help" type="text"
           {{$inputSettings->regex}} {{$inputSettings->required }} {{$inputSettings->writable }}
           value="{{isset(inputSetValue($inputSettings->key,$inputSettings->value)->digitC) ? inputSetValue($inputSettings->key,$inputSettings->value)->digitC : inputSetValue($inputSettings->key,$inputSettings->value) }}" name="{{$inputSettings->id}}"
           placeholder="{{$inputSettings->placeholder}}">
</div>
