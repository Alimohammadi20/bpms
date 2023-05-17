<div class="form-group mx-2">
    <label for="exampleFormControlTextarea1">{{$inputSettings->label}}</label>
    <textarea class="form-control p-2 textarea-input {{$inputSettings->hasError}}"
              id="exampleFormControlTextarea1" rows="5"
              placeholder="{{$inputSettings->placeholder}}"
              {{$inputSettings->required }} {{$inputSettings->writable }}
              name="{{$inputSettings->id}}">{{inputSetValue($inputSettings->key,$inputSettings->value)}}</textarea>
</div>

