<div class="form-group  mb-0 px-md-1">
    @if(!isset($oldData))
        <select name="{{prepareElementID($inputSettings,$index,$isStruct)}}" class="process-input" style="min-width: 200px !important;"
            {{$inputSettings->required }} {{$inputSettings->writable }}>
            <option value="">انتخاب کنید ...</option>
            @foreach($input->Values as $selectKey=>$value)
                <option
                    value="{{$selectKey}}"
                    {{(!isset($isStruct)) ? ( $data->{$key} == $selectKey ? "selected" : "" ) : null }}>
                    {{$value}}
                </option>
            @endforeach
        </select>

    @else
        <select name="{{prepareElementID($inputSettings,$index,$isStruct)}}" class="process-input" style="min-width: 200px !important;"
            {{$inputSettings->required }} {{$inputSettings->writable }}>
            <option value="">انتخاب کنید ...</option>
            @foreach($input->values as $selectKey=>$value)
                <option
                    value="{{$selectKey}}"
                    {{ isset($oldData) ? ($oldData->{$inputSettings->key}== $selectKey? "selected" : "") : ""}}>
                    {{$value}}
                </option>
        @endforeach
    @endif
</div>
