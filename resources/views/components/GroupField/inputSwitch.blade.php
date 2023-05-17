@if($selectType)
    <div class="d-inline-block form-group  px-md-4">
        <select class="process-input px-2 " id="comboBox-list-{{$loop->index}}">
            <option value=""> انتخاب کنید ...</option>
            @foreach($selectBox as $selectKey=>$value)
                <option value="{{$selectKey}}">{{$value}}</option>
            @endforeach
        </select>
    </div>
@else
    <div class="form-group  px-md-4">
        <select name="{{$table->id}}[{{$key}}][]"
                class="process-input" {{ (!$input->Writable)? 'disabled' : '' }}>
            <option value=""></option>
            @foreach($input->Values as $selectKey=>$value)
                <option
                    value="{{$selectKey}}" {{(!isset($isStruct)) ? ( $data->{$key} == $selectKey ? "selected" : "" ) : null }}>{{$value}}</option>
            @endforeach
        </select>
        @error($key)
        <small id="emailHelp py-2">
            <div class="error-msg">{{ $message }}*</div>
        </small>
        @enderror
    </div>
@endif


