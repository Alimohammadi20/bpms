<div class="form-check rtl  px-md-4">
    {{--    <input type="hidden" value="false"--}}
    {{--           name="{{$inputSettings->name}}">--}}
    {{--    <input class="form-check-input " type="checkbox"--}}
    {{--           value="true" {{ $inputSettings->value}} {{ $inputSettings->writable }}--}}
    {{--           name="{{$inputSettings->name}}" id="groupField.{{$inputSettings->name}}">--}}
    {{--    <label class="form-check-label  pr-4" for="groupField.{{$inputSettings->name}}">--}}
    {{--        {{$inputSettings->label}}--}}
    {{--    </label>--}}
    <label class="switch switch-lg">
        <span class="switch-label  ps-0 pe-2">{{$inputSettings->label}}</span>
        <input type="hidden" value="false" name="{{$inputSettings->id}}">
        <input type="checkbox" class="switch-input" name="{{$inputSettings->id}}"
               value="true" {{inputSetValue($inputSettings->key,$inputSettings->value) ? 'checked' : ($inputSettings->value == 'true' ? 'checked' : '')}}
               onclick="{{ $inputSettings->writableValueBoolean ?: "return false;" }}">
        <span class="switch-toggle-slider">
            <span class="switch-on">
                بلی
{{--                <i class="bx bx-check"></i>--}}
            </span>
            <span class="switch-off">
                خیر
{{--                <i class="bx bx-x"></i>--}}
            </span>
        </span>
    </label>


</div>


