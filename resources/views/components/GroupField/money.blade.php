<div class="form-group  px-md-2">
    <label for="">{{$inputSettings->label}}</label>
    <input class="process-input money-input {{$inputSettings->hasError}}"
           id="exampleInput{{$key}}" aria-describedby="{{$key}}Help" type="text"
           value="{{ (isset($input->Value))? toFarsiNumber(number_format((int)$input->Value)) :'' }}"
           name="{{$inputSettings->name}}" placeholder="{{$inputSettings->placeholder}}"
           {{$inputSettings->required }} {{$inputSettings->writable }} {{$inputSettings->regex}}>
    {{formatPriceUnits($input->Value)}}
</div>
