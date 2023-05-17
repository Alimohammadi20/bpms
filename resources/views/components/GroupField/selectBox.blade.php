@php
    $selectedItem = inputSetValue($inputSettings->key,$inputSettings->value);
@endphp
<div class="form-group  px-md-2">
    <label for="">{{ $inputSettings->label}}</label>
    <select name="{{$inputSettings->id}}" id="{{$inputSettings->id}}"
            class="process-input d-inline-block {{$inputSettings->enumSelect}}  {{$inputSettings->hasError}}"
        {{$inputSettings->required }} {{$inputSettings->writable }} >
        <option value="">انتخاب کنید ...</option>
        @if($inputSettings->writableValueBoolean)
            @foreach($input->values as $key=>$value)
                <option value="{{$key}}"{{$selectedItem ==$key ? "selected" :"" }}>
                    {{$value}}
                </option>
            @endforeach
        @else
            <option value="{{ $inputSettings->value  }}" selected>
                {{($input->values->{$inputSettings->value})}}
            </option>
        @endif
    </select>
</div>
