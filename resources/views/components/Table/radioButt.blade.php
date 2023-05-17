<div class="form-check rtl px-5">
    @php($values=json_decode($input['type_value']))

    @foreach($values as $key=>$value)
        <input type="radio" id="{{$key}}" name="{{$key}}" value="{{$key}}">
        <label for="{{$key}}">{{$value}}</label>
        <br>
    @endforeach
</div>
