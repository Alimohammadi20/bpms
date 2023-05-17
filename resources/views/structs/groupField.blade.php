@php
    /*    $validation = session('taskValidation',[]);
        $writable = session('writeable_or_not_property',[]);*/
        $groupTitle = $groupField->name;
        $formProperties = ($isList) ? $groupField : $groupField->formProperties ;
        if (isset($oldDataIndex)){
            unset($input);
            $formProperties=$groupListField->value->groupItems->{$groupFieldId};
        }
        $filesInput = [];
        $firstFile = $firstCheckBox= true;
@endphp
<div
    @if(isset($oldDataIndex))
        id="{{"row-list-$oldDataIndex"}}"
    @else
        @if($isList)
            template-ref="temlpate" id="{{$groupField->id}}">
    @else
        id="{{$groupField->id}}" >
    @endif
    @endif

    <div class="card card-action groupField">
        <div id="card-header-{{$loop->iteration}}" class="card-header card-collapsible card-header-padding">
            <div class="card-action-title">
                @if($isList)
                    <a class="btn-list-remove mr-2" style="margin: auto;  vertical-align: middle;"
                       data-id="{{!isset($oldDataIndex) ? "@id" : "row-list-$oldDataIndex" }}">
                        <img src="{{asset('icons/delete(1).svg')}}" alt="delete(1).svg" style="width: 15px">
                    </a>
                @endif
                <i style="color: white;" class="fa-sharp fa-solid fa-record-vinyl"></i>
                <p class="d-inline">{{ $groupTitle}}</p>
            </div>
            <div id="card-action-element-{{$loop->iteration}}" class="card-action-element">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row pt-2 collapse show groupField-body">
            @foreach($formProperties as $key =>$input)
                @if($input->readable)
                    @switch($input->type)
                        @case("string")
                        @case("double")
                            <div class="col-md-4 col-xxl-3 mt-2">
                                @include('services.bpms2.components.GroupField.txtInput',['inputSettings'=>$input,'otherClass'=>''])
                            </div>
                            @break
                        @case('boolean')
                            @if($firstCheckBox)
                                <div class="col-12"></div>
                                @php $firstCheckBox = false; @endphp
                            @endif
                            <div class="col-xl-6 col-xxl-3 col-md-6  mt-5 mb-1">
                                @include('services.bpms2.components.GroupField.checkBox',['inputSettings'=>$input])
                            </div>
                            @break
                        @case('description')
                        @case('textarea')
                            <div class="col-12  mt-2">
                                @include('services.bpms2.components.GroupField.textArea',['inputSettings'=>$input])
                            </div>
                            @break
                        @case('TEXTEDITOR')
                            <div class="col-12  mt-2">
                                @include('services.bpms2.components.GroupField.textEditor')
                            </div>
                            @break
                        @case('enum')
                            <div class="col-xl-6 col-xxl-3 col-md-6 mt-2">
                                @include('services.bpms2.components.GroupField.selectBox',['inputSettings'=>$input,'input'=>$input])
                            </div>
                            @break
                        @case("file")
                            @if($firstFile)
                                <div class="col-12"></div>
                                @php $firstFile = false; @endphp
                            @endif
                            <div class="col-xl-6 col-lg-12  mt-2 row">
                                @include('services.bpms2.components.GroupField.uploadDocument',['inputSettings'=>$input])
                            </div>
                            {{--                        @php                        --}}
                            {{--                            $filesInput[] = $input;--}}
                            {{--                        @endphp--}}
                            @break
                        @case('money')
                            <div class="col-md-4 col-xxl-3  mt-2">
                                @include('services.bpms2.components.GroupField.txtInput',['inputSettings'=>$input,'otherClass'=>'money-input'])
                            </div>
                            @break
                        @case('long')
                            <div class="col-md-4 col-xxl-3  mt-2">
                                @include('services.bpms2.components.GroupField.txtInput',['inputSettings'=>$input,'otherClass'=>'long-input'])
                            </div>
                            @break
                        @case("datePicker")
                            <div class="col-md-4 col-xxl-3 mt-2">
                                @include('services.bpms2.components.GroupField.datePicker',['inputSettings'=>$input])
                            </div>
                            @break
                        @case("inquiry")
                            <div class="col-md-6 col-lg-4">
                                @include('services.bpms2.components.Input.receipt')
                            </div>
                            @break
                        @case('radioBtn')
                            <div class="col-12 mt-2">
                                @include('services.bpms2.components.GroupField.radioButt')
                            </div>
                            @break
                    @endswitch
                @endif
            @endforeach

            {{--            @if($filesInput != [])--}}
            {{--                <div class="accordion">--}}
            {{--                    <h2 class="accordion-header">--}}
            {{--                        <button type="button" class="accordion-button d-block" data-bs-toggle="collapse"--}}
            {{--                                aria-controls="accordionIcon-1"--}}
            {{--                                data-bs-target="#{{(str_contains($groupField->id,'$')) ? explode('$',$groupField->id)[1] : $groupField}}accordionStyle1-2"--}}
{{--                                aria-expanded="true">--}}
{{--                            <div class="divider">--}}

{{--                                <div class="divider-text">ضمایم<i class="fa fa-arrow-down mx-2"></i></div>--}}
{{--                            </div>--}}

{{--                        </button>--}}
{{--                    </h2>--}}

{{--                    <div id="{{(str_contains($groupField->id,'$')) ? explode('$',$groupField->id)[1] : $groupField}}accordionStyle1-2" class="accordion-collapse collapse show"--}}
{{--                         data-bs-parent="#{{(str_contains($groupField->id,'$')) ? explode('$',$groupField->id)[1] : $groupField}}accordionStyle1" style="">--}}
{{--                        <div class="accordion-body lh-2 row">--}}
{{--                            @foreach($filesInput as $input)--}}
{{--                                <div class="col-lg-6  mt-2">--}}
{{--                                    @include('services.bpms2.components.GroupField.uploadDocument',['inputSettings'=>$input])--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>
    </div>
</div>
{{--@php
    if (!isset($oldDataIndex)){
        session(['taskValidation'=>$validation,'writeable_or_not_property'=>$writable]);
    }
@endphp--}}

{{--
@php
    if (!isset($oldDataIndex)){
        $section = $isList ? ("لیست") : ("بخش") ;
       $writable[$key] = $input->writable;
        if ($input->writable){
            $validationIndex = ($isList) ? "groupList.{$groupListField->id}.$groupFieldId.*.$key" : $key ;
           // $validation['rules'][$validationIndex] = $input->validator != null ? (json_decode($input->validator)!= null ? json_decode($input->validator) : []) : [];
            if($isList){
                $validation['attributes']["groupList.{$groupListField->id}.{$groupFieldId}.*.$key"] = $input->Name . " در $section " . $groupTitle;
            }else{
                $validation['attributes'][$key] = $input->Name . " در $section " . $groupTitle;
            }
        }
   }else{
        if ($oldDataIndex == '@index'){
           break;
         }
   }
 $inputSettings = collect();
    $inputSettings->regex = $input->Expression ? "regex={$input->Expression->Regex}" :'' ;
    $inputSettings->label = (($input->Required)? ' * ' : '').$input->Name;
    $inputSettings->required = ($input->Required)? 'required' : '' ;
    $inputSettings->writable = (!$input->Writable)? 'readonly="readonly"' : '' ;
    $inputSettings->writableValueBoolean = $input->Writable;
    $inputSettings->placeholder =isset($input->Placeholder) ? $input->Placeholder : '';
    $inputSettings->hidden =str_contains(strtolower($key), 'hiden') ? "d-none" : '';

    if ($input->Type == 'string'){
       switch (strtolower($key)){
           case '_ymdatetime_':
                $inputSettings->component = "pdpDefault";
        $inputSettings->disabled = "";
        if (strpos(strtolower($key),'birthdate') > 0){
            $inputSettings->component = "pdpBirthday";
        }elseif (strpos(strtolower($key),'fromdate')){
            $inputSettings->component = "pdpFromDate";
        }elseif (strpos(strtolower($key),'todate')){
            $inputSettings->component = "pdpToDate";
            $inputSettings->disabled ='readonly="readonly"';
        }
       break;
       case 'carplaqueir':
            $inputSettings->values = ['ه','و','ن','م','ل','ق','ط','س','د','ج','ب','الف','ی','ت','ژ','معلولین'];
       break;
       }
    }
    if (!$isList && $input->Type == 'enum' && str_starts_with(strtolower($key),'selectwithfilter')){
      $inputSettings->enumSelect ='select2Component';
    }else{
        $inputSettings->enumSelect ='';
    }
    if (isset($oldData)){
    $inputSettings->hasError = $errors->has("groupList.{$groupListField->id}.{$groupFieldId}.{$oldDataIndex}.{$key}") ? "error-msg-input" : "";
    $inputSettings->name = "groupList[{$groupListField->id}][{$groupFieldId}][{$oldDataIndex}][{$key}]" ;
    switch ($input->Type){
        case 'boolean':
           $inputSettings->value =isset($oldData[$key]) ? ($oldData[$key]? "checked " :  "" ) : "";
            break;
        case 'money':
            $inputSettings->value = isset($oldData[$key]) && $oldData[$key] !=''  ? (number_format((int)$oldData[$key])) : "" ;
            break;
        case 'file':
             $inputSettings->value = $inputSettings->downloadable = $inputSettings->hasFile = null;
             $file = isset($oldData[$key]) ?  json_decode($oldData[$key]) : null;
             if(isset($file->fileName) && $file->fileName != ''){
                 $inputSettings->fileName = $file->fileName;
                 $inputSettings->value =prepareLinkDownload($file->fileName) ;
             }
            if($input->File?->downloadable){
                 $inputSettings->downloadable = isset($input->File->downloadLink) ? $input->File->downloadLink : route('process.download.file',['filename'=>$input->File->fileName,'variable'=>$key]);
            }
            if (isset($input->File)){
                $inputSettings->hasFile = preparePlatformFile($input->File);
            }
            unset($file);
            $filesInput = $inputSettings;
            break;
        default:
            $inputSettings->value = isset($oldData[$key]) ? $oldData[$key] : "" ;
        break;
    }
    }else{
    $inputSettings->name = ($isList) ? "groupList[{$groupListField->id}][{$groupFieldId}][@index][{$key}]" : $key ;
    switch ($input->Type){
        case 'boolean':
           $inputSettings->value = old($key) ?(filter_var($input->Value, FILTER_VALIDATE_BOOLEAN)? "checked"  : "") : (filter_var($input->Value, FILTER_VALIDATE_BOOLEAN) ? "checked" :'');
            break;
        case 'enum':
           $inputSettings->value =  old($key) ??  $input->Value ;
           $inputSettings->writable = (!$input->Writable)? 'disabled' : '' ;
           break;
        case 'money':
            $inputSettings->value =  old($key) ?  old($key) : ( $input->Value ? (number_format((int)$input->Value)) : "" );
            break;
        case 'textarea':
           $inputSettings->value = (isset($data) ? $data->{$key} : '' ) . (isset($input->Value))? $input->Value :'';
            break;
        case 'file':
             $inputSettings->value = $inputSettings->downloadable = $inputSettings->hasFile = null;
             if (str_contains(strtolower($key),'video')){
                 $inputSettings->isVideo = true;
             }else{
                 $inputSettings->isVideo = false;
             }
            if($input->File?->downloadable){
                 $inputSettings->downloadable = isset($input->File->downloadLink) ? $input->File->downloadLink : route('process.download.file',['filename'=>$input->File->fileName,'variable'=>$key]);
            }
            if (isset($input->File)){
                if ($input->File->downloadLink){
                    $inputSettings->hasFile =$input->File->downloadLink;
                }else{

                $inputSettings->hasFile = preparePlatformFile($input->File);
                }
            }
            if (str_contains($input->Value,'base64')){
            $inputSettings->value = $input->Value;
            }
            $file = json_decode($input->Value);
            if(isset($file->fileName) && $file->fileName != ''){
                 $inputSettings->fileName = $file->fileName;
                 $inputSettings->value =prepareLinkDownload($key,$file->fileName) ;
                 $inputSettings->defaultValue =  $input->Value;
             }
            array_push($filesInput,$inputSettings);
            $filestest =true;
            break;
        default:
           $inputSettings->value =old($key) ? (old($key)) : ((isset($input->Value))? ($input->Value) :'') ;
        break;
    }
    $inputSettings->hasError = $errors->has($key) ? "error-msg-input" : "";
    }
@endphp--}}
