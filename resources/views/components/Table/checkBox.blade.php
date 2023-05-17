<div class="form-check rtl  mb-0 px-md-1">
    <input class="form-check-input {{$inputSettings->hasError}}" type="checkbox"
           value="true" name="{{prepareElementID($inputSettings,$index,$isStruct)}}" {{$inputSettings->required }} {{$inputSettings->writable }}
           {{$oldData->{$inputSettings->key} }} id="disabledFieldsetCheck-{{prepareElementID($inputSettings,$index,$isStruct)}}">
    <label class="form-check-label  pr-4" for="disabledFieldsetCheck-{{prepareElementID($inputSettings,$index,$isStruct)}}">
        {{$inputSettings->label}}
    </label>
</div>
