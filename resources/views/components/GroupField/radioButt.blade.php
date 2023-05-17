@php
    $selectedItem = inputSetValue($inputSettings->key,$inputSettings->value);
@endphp
<div class="form-check rtl px-5">
    @php($values=json_decode($input['type_value']))
    @foreach($values as $key=>$value)
        <input type="radio" id="{{$key}}" name="{{$key}}" {{$selectedItem == $key ? "checked" : ""}}
        value="{{$key}}" {{ (!$input->Writable)? 'disabled' : '' }}>
        <label for="{{$key}}">{{$value}}</label>
        <br>
    @endforeach
</div>
