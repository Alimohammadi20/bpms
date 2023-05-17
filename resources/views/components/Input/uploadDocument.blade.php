<label>{{$input->name}}</label>
<label class="input-file">
    <div class="upload-btn">
        <img src="{{asset('icons/upload.svg')}}"
             alt="upload.svg"><span> انتخاب {{ ($input->required)? ' * ' : '' }} {{$input->name}} </span></div>
    <input type="hidden" value name="{{$input->id}}">
    <input {{ (!$input->writable)? 'disabled' : '' }}
           {{ ($input->required)? 'required' : '' }}
           accept=".jpg,.png,.jpeg,.tiff|image/*,application/pdf,video/mp4"
           type="file" class="fileInput" name="{{$input->id}}">
</label>
@if($input->value)
    <a href="{{route('process.download.file',['filename'=>$input->value->fileName,'variable'=>$propertyKey])}}"
       class="downlaod-btn">دانلود</a>
@endif




{{--@if($inputSettings->hasFile && !$inputSettings->downloadable)--}}
{{--    <label>{{$inputSettings->label}}</label>--}}
{{--    <div class="text-center">--}}
{{--        <img src="{{asset($inputSettings->hasFile)}}" class="img-fluid" alt="image">--}}
{{--    </div>--}}
{{--@else--}}
{{--    <div class="">--}}
{{--        <label>{{$inputSettings->label}}</label>--}}
{{--        <label class="input-file">--}}
{{--            @if($inputSettings->value)--}}
{{--                <a href="{{$inputSettings->value}}" target="_blank" class="downlaod-btn"--}}
{{--                   download="{{$inputSettings->fileName}}">دانلود {{$inputSettings->label}}</a>--}}
{{--            @endif--}}
{{--            @if($inputSettings->writable === '')--}}
{{--                <div--}}
{{--                    class="upload-btn {{$inputSettings->hasError}}">--}}
{{--                    <img src="{{asset('icons/upload.svg')}}" alt="image">--}}
{{--                    انتخاب {{$inputSettings->label}}--}}
{{--                </div>--}}
{{--                <input type="hidden" value name="{{$inputSettings->name}}">--}}
{{--                <input type="hidden" class="fileInput " accept=".jpg,.png,.jpeg,.tiff|image/*,application/pdf"--}}
{{--                       value="{{isset($inputSettings->defaultValue) ?  $inputSettings->defaultValue :'' }}"--}}
{{--                       name="{{$inputSettings->name}}">--}}
{{--                <input type="file" class="fileInput " accept=".jpg,.png,.jpeg,.tiff|image/*,application/pdf"--}}
{{--                       {{$inputSettings->required }} {{$inputSettings->writable }}--}}
{{--                       name="{{$inputSettings->name}}">--}}
{{--            @endif--}}
{{--        </label>--}}
{{--    </div>--}}
{{--@endif--}}
{{--@if($inputSettings->downloadable)--}}
{{--    <a href="{{$inputSettings->downloadable}}"--}}
{{--       target="_blank"--}}
{{--       class="">--}}
{{--        <label class="input-file">--}}
{{--            <div class="downlaod-btn">--}}
{{--                <i class="fas fa-upload mx-1" style="transform: rotate(180deg)"></i> دانلود فایل--}}
{{--            </div>--}}
{{--        </label>--}}
{{--    </a>--}}
{{--@endif--}}
@error($input->id)
<small id="emailHelp py-2">
    <div class="error-msg">{{ $message }}*</div>
</small>
@enderror
