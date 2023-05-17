@php
    $lastRowGroupField =0;
          $colsType =collect();
/*          $datas = (old('groupList')) ? ( old('groupList') != null  ? (isset(old('groupList')[$input->id]) ? old('groupList')[$input->id]:[]) : []) : (count((array)$input->value->data)>0 ? $input->value->data : [] ); */
$datas = [];
   /*     if ($input->required){
           $validation['rules']["groupList.{$input->id}"] = "required";
           $validation['attributes']["groupList.{$input->id}"] = $input->name;
           session(['taskValidation'=>$validation]);
          }*/

@endphp
<div>
    <h6 class="d-inline-block">{{$input->name}} </h6>
    @include('services.bpms2.components.GroupField.inputSwitch',['selectBox'=>$input->values,'input'=>$input,'selectType'=>true])
    <a data-list-id="list-{{$loop->index}}" class="add-list-btn m-2">
{{--        <div class="btn" data-list-id="list-{{$loop->index}}">--}}
{{--            <i class="fa-solid fa-plus ml-1" data-list-id="list-{{$loop->index}}"></i>--}}
{{--        </div>--}}
             <span class="btn" data-list-id="list-{{$loop->index}}" style="height: 25px">
                <i class="fa-solid fa-plus pb-2" data-list-id="list-{{$loop->index}}"></i>
            </span>
        افزودن
    </a>
</div>
<div id="choose-option-msg" style="display: none">
    <p>
        لطفا یکی از مقادیر بالا را انتخاب کنید
    </p>
</div>
@error("groupList.{$input->id}")
<p class="error-msg">{{$message}}</p>
@enderror

<div class="w-100 my-3 d-none" id="pattern-list-{{$loop->index}}">
    @foreach($input->formProperties as $groupFieldId =>$groupField)
        @include('services.bpms2.structs.groupField',['groupField'=>$groupField,'groupListField'=>$input,'isList'=>$isList])
    @endforeach
</div>


<div class="w-100 my-3 " id="user-list-{{$loop->index}}">
    @foreach($datas as $oldGroupFieldKey =>$oldDatas)
        @foreach($oldDatas as $oldDataIndex =>$oldData )
            @php
                $lastRowGroupField=$oldDataIndex;
                $oldData=(array)$oldData;
            @endphp
            @include('services.bpms2.structs.groupField',['groupListField'=>$input,'isList'=>$isList,'oldData'=>$oldData,'oldDataIndex'=>$oldDataIndex,'groupFieldId'=>$oldGroupFieldKey])
        @endforeach
    @endforeach
</div>
<input type="hidden" name="lastRowGroupField" id="lastRowGroupField"
       value="{{old('lastRowGroupField')?old('lastRowGroupField') : $lastRowGroupField}}">
