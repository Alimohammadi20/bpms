<div class="row px-2 {{$inputSettings->hidden}}">
    <div class="col-12">
        <label for="">{{ $inputSettings->label}}</label>
    </div>
    <div class="col-2 form-group px-md-2 ">
        <input class="plaque-input plaque-component" id="plaqueiranNums"
               aria-describedby="{{$key}}Help" type="number" min="10" max="99"
               {{$inputSettings->regex}} required {{$inputSettings->writable }}
               value="{{ old("plaque.iranNums") ? (old("plaque.iranNums")) : ''}}"
               name="{{($isList) ? "groupList[{$groupListField->id}][{$groupFieldId}][@index][carPlaqueIR][iranNums]" :"carPlaqueIR[iranNums]"}}"
               placeholder="ایران 11">
    </div>
    <div class="col-3 form-group  px-md-2 ">
        <input class="plaque-input plaque-component" id="plaquesecondNums"
               aria-describedby="{{$key}}Help" type="number" min="100" max="999"
               {{$inputSettings->regex}} required {{$inputSettings->writable }}
               value="{{ old("plaque.secondNums") ? (old("plaque.secondNums")) :''}}"
               name="{{($isList) ? "groupList[{$groupListField->id}][{$groupFieldId}][@index][carPlaqueIR][secondNums]" :"carPlaqueIR[secondNums]"}}"
               placeholder="111">
    </div>
    <div class="col-3 form-group  px-md-2 text-center">
        <select class="plaque-input plaque-component" id="plaquechar"
                name="{{($isList) ? "groupList[{$groupListField->id}][{$groupFieldId}][@index][carPlaqueIR][charecter]" :"carPlaqueIR[charecter]"}}"
                {{$inputSettings->regex}} required {{$inputSettings->writable }}>
            <option value="">انتخاب کنید ...</option>
            @foreach($inputSettings->values as $item)
                <option value="{{$item}}" {{ old('plaque.char') === $item ? "selected" : "" }}>{{$item}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-3 form-group  px-md-2 ">
        <input class="plaque-input  plaque-component " id="plaquefirstNums"
               aria-describedby="{{$key}}Help" type="number" min="10" max="99"
               {{$inputSettings->regex}} required {{$inputSettings->writable }}
               value="{{ old("plaque.firstNums") ? (old("plaque.firstNums")) : ''}}"
               name="{{($isList) ? "groupList[{$groupListField->id}][{$groupFieldId}][@index][carPlaqueIR][firstNums]" :"carPlaqueIR[firstNums]"}}"
               placeholder="11">
    </div>
</div>
