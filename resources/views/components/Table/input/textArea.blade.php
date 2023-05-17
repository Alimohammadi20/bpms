<div class="form-group mb-0" style="width: 100%;">
        <textarea class="form-control p-2"
                  id="exampleFormControlTextarea1" name="{{prepareElementID($inputSettings,$index,$isStruct)}}"
                  {{$inputSettings->regex}} {{$inputSettings->required }} {{$inputSettings->writable }}
                  rows="5" cols="100" style="min-width:300px"
                  placeholder="{{$inputSettings->placeholder}}">{{ $oldData->{$inputSettings->key} }}</textarea>
</div>
