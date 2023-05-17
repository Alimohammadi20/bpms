@if(isset($oldData))
    @php
        if (isset($oldData->{$inputSettings->key})){
            $file =  json_decode($oldData->{$inputSettings->key});
        }else{
            $file = null;
        }
    @endphp
    @if($file != null)
        <a href="{{prepareLinkDownload($file->fileName)}}" download="{{$file->fileName}}" class="downlaod-btn-table-data"
           target="_blank"><i class="fa-solid fa-download"></i></a>
    @endif
    @php
        unset($file);
    @endphp
@endif
