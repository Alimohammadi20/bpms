@if($inputSettings->writable === '')
    @php
        $id = prepareElementID($inputSettings,$index,$isStruct);
    @endphp
    <label class="input-file">
        <div class="upload-btn {{$inputSettings->hasError}}">
            <img src="{{asset('icons/upload.svg')}}" alt="upload.svg"><span>انتخاب فایل</span></div>
        <input type="hidden" value="@file" name="{{$id}}">
        <input type="file" class="fileInput" {{$inputSettings->required }}{{$inputSettings->writable }}
        accept=".jpg,.png,.jpeg,.tiff|image/*,application/pdf"
               name="{{$id}}">
    </label>
@endif
@if(isset($oldData))
    @php
        if (isset($oldData->{$inputSettings->key})){
            $file =  json_decode($oldData->{$inputSettings->key});
        }else{
            $file = null;
        }
    @endphp
    @if($file != null)
        <a href="{{prepareLinkDownload($file->fileName)}}" download="{{$file->fileName}}" class="downlaod-btn-table"
           target="_blank">دانلود فایل</a>
    @endif
    @php
        unset($file);
    @endphp
@endif
