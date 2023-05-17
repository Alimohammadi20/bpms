@if(isset($input))
    <div class="form-group">
        <label for="exampleFormControlTextarea1">{{$input->name}}</label>
        <textarea class="form-control  p-2"
                  {{ (!$input->writable)? 'disabled' : '' }}
                  {{ ($input->required)? 'required' : '' }}
                  id="exampleFormControlTextarea1"
                  name="{{$input->id}}"
                  rows="5">{{$input->value}}</textarea>

    </div>
@else
    <div class="alert alert-primary mt-2 py-3" role="alert"
         style="color:#071A63;font-size: 14px;width: 100%;float: right">
        {{$all_form_properties["DescriptionForm"]->value}}
    </div>
@endif
