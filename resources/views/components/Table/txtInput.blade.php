<div class="form-group mb-0 px-md-1" style="position: relative">
    <input class="process-input {{$otherClass ?? ''}} {{$inputSettings->hasError}}" id="exampleInput{{$key}}"
           aria-describedby="{{$key}}Help" type="text"
           {{$inputSettings->regex}} {{$inputSettings->required }} {{$inputSettings->writable }}
           value="{{tableStringSetValue($inputSettings,$oldData) }}"
           name="{{ prepareElementID($inputSettings,$index,$isStruct)}}"
           placeholder="{{$inputSettings->placeholder}}">
    {{--    @if(isset($otherClass) && $otherClass === 'money-input')--}}
    {{--        <small class="money-unit">{{formatPriceUnits(str_replace(',','',$inputSettings->value))}}</small>--}}
    {{--    @endif--}}
</div>
