<div class="form-group mb-0">
    <input class=" process-input flatpickr-date {{$inputSettings->component}}" autocomplete="off"
           aria-describedby="{{$key}}Help" type="text"
           {{$inputSettings->required }} {{$inputSettings->disabled }} {{$inputSettings->writable == 'readonly="readonly"' ? "disabled" : '' }}
           value="{{($inputSettings->value)}}"  name="{{$inputSettings->name}}"
           placeholder="{{$inputSettings->placeholder}}">
</div>
