@pushOnce('head')
    <link rel="stylesheet" href="{{asset("assets/vendor/libs/flatpickr/flatpickr.css")}}"/>
@endPushOnce
<div class="form-group px-md-2">
    <!-- Date Picker-->
    <label for="exampleInputEmail1">
        {{$inputSettings->label}}
    </label>
    <input type="text" class="form-control flatpickr-date {{$inputSettings->component}} {{$inputSettings->hasError}}"
           autocomplete="off"
           aria-describedby="{{$inputSettings->id}}Help" id="{{$inputSettings->id}}"
           {{$inputSettings->required }}   value="{{ prepareDateForShow(inputSetValue($inputSettings->key,$inputSettings->value)) }}"
           name="{{$inputSettings->id}}" {{$inputSettings->writable == 'disabled="disabled"' ? "disabled" : '' }}
           placeholder="{{$inputSettings->placeholder}}">
    <!-- /Date Picker -->
</div>

@pushOnce('script')
    <script src="{{asset('assets/vendor/libs/jdate/jdate.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr-jdate.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/flatpickr/l10n/fa-jdate.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/pickr/pickr.js')}}"></script>
    <script src="{{asset('assets/js/forms-pickers.js')}}"></script>
@endPushOnce

{{--           regex="([0-9]{4}(\/)[0]{1}[0-9]{1}(\/)[0-2]{1}[0-9]{1}|[0-9]{4}(\/)[1]{1}[0-2]{1}(\/)[3]{1}[0-1]{1}|[0-9]{4}(\/)[0]{1}[0-9]{1}(\/)[3]{1}[0-1]{1}|[0-9]{4}(\/)[1]{1}[0-2]{1}(\/)[0-2]{1}[0-9]{1})"--}}

