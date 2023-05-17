@if($inputSettings->hasFile && !$inputSettings->downloadable)
    <label>{{$inputSettings->label}}</label>
    <div class="text-center">
        <img src="{{asset($inputSettings->hasFile)}}" class="img-fluid" alt="image">
    </div>
@else
    <div class="col-md-4">
        <label>{{$inputSettings->label}}</label>
        <label class="input-file">
            <a href="{{route('cartable.download.file',['processInstanceId'=>session("task")->processInstanceId,'variableName'=>$inputSettings->key])}}"
               {{ $inputSettings->id == 'SabtImage'  ? 'download-before=true' : '' }}
               target="_blank" class="downlaod-btn btn btn-outline-success d-inline-block"><i class="fas fa-upload mx-1" style="transform: rotate(180deg)"></i>دانلود فایل</a>
            @if($inputSettings->writable === '')
                <div class="upload-btn d-inline-block {{$inputSettings->hasError}}">
                    <img src="{{asset('icons/upload.svg')}}" alt="image">
                    انتخاب فایل
                </div>
                <input type="hidden" value name="{{$inputSettings->id}}">
                <input type="hidden" class="fileInput " accept=".jpg,.png,.jpeg,.tiff|image/*,application/pdf"
                       value="{{isset($inputSettings->defaultValue) ?  $inputSettings->defaultValue :'' }}"
                       name="{{$inputSettings->id}}">
                <input type="file" class="fileInput " accept=".jpg,.png,.jpeg,.tiff|image/*,application/pdf"
                       {{$inputSettings->required }} {{$inputSettings->writable }}
                       name="{{$inputSettings->id}}">
            @endif
        </label>
    </div>
@endif


{{--@if($inputSettings->value)--}}
{{--    --}}{{--                <button href="#" class="btn btn-outline-primary preview-btn"--}}
{{--    --}}{{--                        data-bs-target="#preview-{{$inputSettings->name}}" data-bs-toggle="modal"--}}
{{--    --}}{{--                        data-src="{{$inputSettings->value}}">نمایش--}}
{{--    --}}{{--                </button>--}}
{{--    @if($inputSettings->isVideo)--}}
{{--        <!-- Add New Credit Card Modal -->--}}
{{--        <div class="modal fade text-center" id="preview-{{$inputSettings->name}}" tabindex="-1"--}}
{{--             aria-hidden="true">--}}
{{--            <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">--}}
{{--                <div class="modal-content p-3 p-md-5">--}}
{{--                    <div class="modal-body">--}}
{{--                        <button type="button" class="btn-close" data-bs-dismiss="modal"--}}
{{--                                aria-label="Close"></button>--}}
{{--                        <div class="text-center mb-4">--}}
{{--                            <h3 class="secondary-font">{{$inputSettings->label}}</h3>--}}

{{--                        </div>--}}
{{--                        <video class="preview-box" controls style="width: 100%;height: auto;">--}}
{{--                            <source type="video/webm" src="{{$inputSettings->value}}">--}}
{{--                            مرورگر شما ساپورت نمیکند--}}
{{--                        </video>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!--/ Add New Credit Card Modal -->--}}
{{--    @else--}}
{{--        --}}{{--                    <div class="modal fade text-center" id="preview-{{$inputSettings->name}}" tabindex="-1"--}}
{{--        --}}{{--                         aria-hidden="true">--}}
{{--        --}}{{--                        <div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">--}}
{{--        --}}{{--                            <div class="modal-content p-3 p-md-5">--}}
{{--        --}}{{--                                <div class="modal-body">--}}
{{--        --}}{{--                                    <button type="button" class="btn-close" data-bs-dismiss="modal"--}}
{{--        --}}{{--                                            aria-label="Close"></button>--}}
{{--        --}}{{--                                    <div class="text-center mb-4">--}}
{{--        --}}{{--                                        <h3 class="secondary-font">{{$inputSettings->label}}</h3>--}}
{{--        --}}{{--                                    </div>--}}
{{--        --}}{{--                                    <img class="preview-box img-fluid" src="{{$inputSettings->value}}">--}}
{{--        --}}{{--                                </div>--}}
{{--        --}}{{--                            </div>--}}
{{--        --}}{{--                        </div>--}}
{{--        --}}{{--                    </div>--}}

@if($inputSettings->id == 'SabtImage')
        <div class="text-center">
            <img class="preview-box img-fluid" src="{{$inputSettings->value}}" style="height: 250px;">
        </div>
@endif

{{--    @endif--}}
{{--@endif--}}
