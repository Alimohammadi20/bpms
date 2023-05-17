
<div class="form-group mb-0">
    <input class=" process-input flatpickr-date {{$inputSettings->component}}" autocomplete="off"
           aria-describedby="{{$key}}Help" type="text"
           {{$inputSettings->required }} {{$inputSettings->disabled }} {{$inputSettings->writable }}
           value="{{tableStringSetValue($inputSettings,$oldData)}}"  name="{{$inputSettings->name}}"
           placeholder="{{$inputSettings->placeholder}}">
</div>
