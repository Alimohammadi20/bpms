<div class="form-group px-0 px-md-5">
    <input style="direction: rtl;display: none"
           {{ ($input->writable==false)? 'disabled' : '' }} type="text"
           value="{{$input->value}}" name="{{$input->id}}" required
           id="{{$input->id}}">
    <div class="row">
        <div class="col-12">


            <div id="my_live_camera">
                <video preload="metadata"  style="" id="video" width="250" height="240" playsinline autoplay
                       muted></video>
            </div>

            <div class="col-12 text-left">
                <a id="start-camera" class="mt-3">روشن کردن دوربین</a>
            </div>
            <div class="col-12 text-left" style="display: none" id="start-record-btn">
                <a id="start-record"
                   style="">{{trans('messages.Start_Recording')}}</a>
            </div>
            <div class="col-12 text-left" style="display: none" id="stop-record-btn">
                <a id="stop-record">{{trans('messages.Stop_Recording')}}</a>
            </div>
            <div class="w-100 text-left">
                <video id="video_preview"
                       controls width="250" height="240"
                       autoplay>
                    not support
                </video>
            </div>
            <div class="col-12 text-left" id="download-video-btn" style="display: none">
                <a id="download-video"
                   download>دانلود ویدیو</a>
                <a id="refresh-page"
                   onClick="window.location.reload();"> ضبط مجدد</a>
            </div>
        </div>
    </div>


    @push('script')
        <script>
            let camera_button = document.querySelector("#start-camera");
            let video = document.querySelector("#video");
            let start_button = document.querySelector("#start-record");
            let start_button_box = document.querySelector("#start-record-btn");
            let stop_button = document.querySelector("#stop-record");
            let stop_button_box = document.querySelector("#stop-record-btn");
            let download_link = document.querySelector("#download-video");
            let download_link_box = document.querySelector("#download-video-btn");
            let refresh_page = document.querySelector("#refresh-page");
            let preview = document.querySelector("#video_preview");

            let camera_stream = null;
            let media_recorder = null;
            let blobs_recorded = [];


            camera_button.addEventListener('click', async function () {
                try {
                    camera_stream = await navigator.mediaDevices.getUserMedia({video: true, audio: true});
                    video.srcObject = camera_stream;
                } catch (error) {
                    return;
                }
                camera_button.style.display = 'none';
                preview.style.display = 'none';
                video.style.display = 'block';
                start_button_box.style.display = 'block';
            });

            document.querySelector("#start-record").addEventListener('click', function () {
                if (MediaRecorder.isTypeSupported('video/webm')){
                    media_recorder = new MediaRecorder(camera_stream, {mimeType: 'video/webm'});
                }else{
                    media_recorder = new MediaRecorder(camera_stream, {mimeType: 'video/mp4'});
                }


                media_recorder.addEventListener('dataavailable', function (e) {
                    blobs_recorded.push(e.data);
                });

                media_recorder.addEventListener('stop', function () {

                    let just_blob = new Blob(blobs_recorded, {type: 'video/webm'});






                    let video_local = URL.createObjectURL(just_blob);
                    download_link.href = video_local;
                    // let file_base_64=blobToBase64(just_blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(just_blob);
                    reader.onloadend = function () {
                        var base64String = reader.result;
                        console.log(base64String)
                        document.getElementById("<?php echo $input->id;?>").value = base64String.substr(base64String.indexOf(', ') + 1);
                        document.getElementById("download-video").src = just_blob;
                    }
                    stop_button_box.style.display = 'none';
                    download_link_box.style.display = 'block';
                    preview.style.display = 'block';
                    preview.src = video_local;
                });
                media_recorder.start(1000);
                start_button_box.style.display = 'none';
                stop_button_box.style.display = 'block';
            });

            stop_button.addEventListener('click', function () {
                media_recorder.stop();
                stop_button_box.style.display = 'none';
                preview.style.display = 'block';
                document.getElementById("my_live_camera").style.display = 'none';
                document.getElementById("download-video-btn").style.display = 'block';
            });
        </script>
    @endpush


</div>
