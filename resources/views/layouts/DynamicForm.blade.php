<div class="center position-fixed" id="preload">
    <img src="{{asset('assets/svg/preload/parsianPreloading.svg')}}" alt="parsianPreloading">
</div>
<div class="auth-page card card-action  w-100">
    @if($all_form_properties->get("DescriptionForm"))
        @include('customer-view.auth.components.Input.headerDescription')
    @endif
    <div class="card-header">
        <div class="card-action-title task-title-name">
            <i class="fa-sharp fa-solid fa-circle"></i>
            <h5>{{isset(session('task')->name) ? session('task')->name :''}}
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasEnd"
                        aria-controls="offcanvasEnd">جزییات وظیفه
                </button>
            </h5>
        </div>
        <div class="card-action-element">
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <a href="javascript:void(0);" class="card-expand"><i class="tf-icons bx bx-fullscreen"></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="{{url()->previous()}}"
                       style="font-size: 18px;display: flex;transform: translate(0px, 4px);"><i
                            class="fa-regular fa-circle-xmark"></i></a>
                </li>
            </ul>
        </div>
    </div>
    @include('customer-view.auth.SideMenuContent')

    @if($all_form_properties->get("helps"))
        @foreach($all_form_properties->get("helps") as $input)
            @include('customer-view.auth.components.Input.help')
        @endforeach
    @endif
    @include('customer-view.auth.ShowErrorAlertBox')
    <form method="POST"
          action="{{$formAction}}"
          accept-charset="UTF-8"
          class="form-horizontal"
          id="processForm"
          role="form" enctype="multipart/form-data">
        @csrf
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active nav-pill-1 tab-header-title" role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home"
                                aria-selected="true">
                            <i class='bx bx-data'></i> اقلام اطلاعاتی
                        </button>
                    </li>
                    @if($all_form_properties->get("tables"))
                        <li class="nav-item">
                        <button type="button" class="nav-link nav-pill-2 tab-header-title" role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-pills-justified-profile"
                                aria-controls="navs-pills-justified-profile"
                                aria-selected="false">
                            <i class='bx bx-table'></i> جداول اطلاعاتی
                        </button>
                    </li>
                @endif
            </ul>
            <div class="tab-content" style="box-shadow: 0 0 0;padding: 0">
                <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                    @if($all_form_properties->get("textEditor"))
                        <div class="col-12 mt-2">
                            @include('customer-view.auth.components.Input.textEditor')
                        </div>
                    @endif
                    @if($all_form_properties->get("input"))
                        <div class="w-100 mx-auto row">
                            @foreach($all_form_properties->get("input") as $inputDeftKey=>$input)
                                @php
                                    if (count(old()) ==0){
                                        $validation['rules'][$inputDeftKey] = $input->required ? "required" : "";
                                        $validation['attributes'][$inputDeftKey] = $input->name;
                                    }
                                @endphp
                                @if($input->readable)
                                    @switch($input->type)
                                        @case("string")
                                        @case("double")
                                        <div class="col-md-4 col-xxl-3 mt-2">
                                            @include('services.bpms2.components.GroupField.txtInput',['inputSettings'=>$input,'otherClass'=>''])
                                        </div>
                                        @break
                                        @case("qrCode")
                                        <div class="col-12 mt-2">
                                            @include('services.bpms2.components.GroupField.QRCode',['inputSettings'=>$input])
                                        </div>
                                        @break
                                        @case('boolean')
                                        <div class="col-md-12  mt-5 mb-1">
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
                                        <div class="col-lg-4 col-lg-3 mt-2">
                                            @include('services.bpms2.components.GroupField.selectBox',['inputSettings'=>$input,'input'=>$input])
                                        </div>
                                        @break
                                        @case("file")
                                            @include('services.bpms2.components.GroupField.uploadDocument',['inputSettings'=>$input])
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
                                        @case('GroupField')
                                        <div class="w-100 my-3 px-0">
                                            @include('services.bpms2.structs.groupField',['groupField'=>$input,'isList'=>false])
                                        </div>
                                        @break
                                        @case('ListGroupField')
                                        <div class="w-100 my-3">
                                            @include('services.bpms2.structs.ListGroupField',['isList'=>true])
                                        </div>
                                        @break
                                    @endswitch
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                @if($all_form_properties->get("tables"))
                    <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                        @foreach($all_form_properties->get("tables") as $tableKey => $input)
                            @php
                                if (hasOldData()){
                                    $input->value  = oldData('tables',$tableKey);
                                }
                            @endphp
                            @if(count($input->value) >0)
                                @if($input->writableValueBoolean)
                                <div class="container-fluid my-5 py-2">
                                    @include('services.bpms2.structs.dataTable',['table'=>$input])
                                </div>
                                @else
                                    <div class="container-fluid my-5 py-2">
                                        @include('services.bpms2.structs.dataTable',['table'=>$input])
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="confirm-btn">
            @if($all_form_properties->get("Cancel"))
                @include('services.bpms2.components.Input.submitBtn',['submitTitle'=>$all_form_properties->get("Cancel")->name,'value'=>'cancel'])
            @endif
            @if($all_form_properties->get("Back"))
                @include('services.bpms2.components.Input.submitBtn',['submitTitle'=>$all_form_properties->get("Back")->name,'value'=>'back'])
            @endif
            @if($all_form_properties->get("ApproveButton"))
                @include('services.bpms2.components.Input.submitBtn',['submitTitle'=>$all_form_properties->get("ApproveButton")->name,'value'=>'next'])
            @else
                @include('services.bpms2.components.Input.submitBtn',['submitTitle'=>trans("تایید"),'value'=>'next'])
            @endif
            <input type="hidden" name="submit_btn" id="hidden_submit" value="">
        </div>
    </form>
</div>
@push('script')
    <script defer src="{{asset('vendor/bpms/js/commons.js')}}"></script>
    <script defer src="{{asset('vendor/bpms/js/userProcess.js')}}"></script>
    @if($all_form_properties->get("scripts"))
        <script !src="">
            @foreach($all_form_properties->get("scripts") as $script)
            eval(` {!!$script->value  !!} `)
            @endforeach
        </script>
    @endif
    <script>
        window.onload = function () {
            let thisElms = $('.downlaod-btn');
            for (let i = 0; i < thisElms.length; i++) {
                let thisElm = $(thisElms[i]);
                let href = thisElm.attr('href')
                let btnAttr = thisElm.attr('download-before')
                if (btnAttr === undefined) {
                    $.ajax({
                        url: href,
                        async: true,
                        success: function (result) {
                            let elm = '';
                            if (result.status) {
                                elm = '<div class="text-center col-md-8">';
                                if (result.fileName.includes('mp4') || result.fileName.includes('webm')) {
                                    let ex = result.fileName.split('.')
                                    elm += `<br><video class="preview-box plyr__video-embed" controls style="width: 100%;height: 250px;">
                                        <source type="video/${ex[1]}" src="${result.link}">
                                        مرورگر شما ساپورت نمیکند
                                    </video>`
                                } else if (result.fileName.includes('pdf')) {
                                    elm += `<a href="${result.link}" target="_blank"><img class="preview-box img-fluid lozad" style="height: 90px;" data-src="/icons/PDF_file_icon.svg.png"></a>`;
                                } else {
                                    elm += `<a href="${result.link}" target="_blank"><img class="preview-box img-fluid lozad" style="height: 180px;" data-src="${result.link}"></a>`;
                                }
                                elm += '</div>'
                            } else {
                                elm = '<div class="text-center col-md-8">';
                                elm += `<img class="preview-box img-fluid lozad" style="height: 180px;" data-src="/icons/image-placeholder.png">`;
                                elm += '</div>'
                            }
                            thisElm.attr('download-before', true)
                            thisElm.parent().parent().parent().append(elm)
                            const observer = lozad();
                            observer.observe();
                        }
                    })
                }
            }
        }
    </script>
@endpush
