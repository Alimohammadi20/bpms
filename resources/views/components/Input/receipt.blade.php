@foreach($input->value as $key=>$value)
    <div class="form-group px-md-4 ">
        <label for="exampleInputEmail1">
            {{$key}}
        </label>
        <input class="form-control custom-input-auth"
               id="exampleInput"
               aria-describedby="Help" type="text" disabled
               value="{{$value}}">
    </div>
@endforeach
