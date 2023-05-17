<div class="form-group mb-0 px-md-1">
    @if(!isset($oldData))
        <input
            class="process-input money-input"
            id="exampleInput{{$key}}"
            aria-describedby="{{$key}}Help"
            type="text"
            {{ (!$input->Writable)? 'disabled' : '' }}
            {{($input->Required) ? "required" : ""}}
            value="{{ (isset($input->Value))? toFarsiNumber(number_format((int)$input->Value)) :'' }}"
            name="table[{{$table->id}}][@index][{{$key}}]"
            placeholder="{{$input->Name}}">
        {{(isset($input->Value))? formatPriceUnits($input->Value) : '1234'}}
    @else
        <input
            class="process-input money-input {{ (isset($index)&& $errors->has("table.$table->id.$index.$key")) ? "error-msg-input" : ""}}"
            id="exampleInput{{$key}}"
            aria-describedby="{{$key}}Help"
            type="text"
            {{ (!$input->Writable)? 'disabled' : '' }}
            {{($input->Required) ? "required" : ""}}
            value="{{ number_format($oldData[$propertyKey])}}"
            name="table[{{$table->id}}][{{$index}}][{{$key}}]"
            placeholder="{{$input->Name}}">
        {{formatPriceUnits($oldData[$propertyKey])}}
    @endif
</div>

