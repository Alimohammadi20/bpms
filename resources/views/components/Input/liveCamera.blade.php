<div class="form-group px-0 px-md-5">
    <label>{{$input->name}}
    </label>
    <input class="d-none"
           {{ ($input->writable==false)? 'disabled' : '' }} type="text"
           value="{{$input->value}}" name="{{$input->id}}" required
           id="{{$input->id}}">
    <div style="width:100%;float: right;">
        <div>
            <div style="text-align: left">
{{--                <video class="video1 d-none" id="video{{$input->id}}" width="250" height="190"--}}
{{--                       autoplay preload="metadata" playsinline muted></video>--}}
                <video preload="metadata" class="video1 d-none" style="" id="video{{$input->id}}" width="250" height="190" playsinline autoplay
                       muted></video>
                <canvas width="250" height="240" class="preview-image d-none" id="canvas-{{$input->id}}"></canvas>
            </div>
        </div>
        <div style="display: none;direction: rtl;text-align: right;" id="preview-label">
            پیش نمایش عکس :
            <br/>
        </div>
        <div class="mt-4" style="text-align: left;padding-top: 15px;">
            <a class="start-camera" id="first-cam-opener"
               image-type="{{$input->id}}">روشن کردن دوربین</a>
        </div>
        <div style="text-align: left;padding-top: 15px;display: none;" id="pic-taker">
            <a class="click-photo" id="take-pic-words"
               image-type="{{$input->id}}">{{trans('messages.Click_Photo')}}</a>
        </div>

    </div>
    @push('script')
        <script>
            const sampleImage = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAMCAgICAgMCAgIDAwMDBAYEBAQEBAgGBgUGCQgKCgkICQkKDA8MCgsOCwkJDRENDg8QEBEQCgwSExIQEw8QEBD/2wBDAQMDAwQDBAgEBAgQCwkLEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBD/wAARCADwAPoDAREAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwDqKsAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgD6KtvhqfjT4D0aW20N/DXiTQVt9PnM1m8VveWR4Eq5ADEDLcHOQwPDIRIHPyfAz4Yxu0b/tDaCGQlSPs0fUf9vFO4HOeOPgnrnhz7BfeE7mTxfo+oxF4NQ0y1LrvU4ZGVC+MdjnnkdQQC4Hn13Z3dhcyWd/azW1xEdskUyFHQ+hU8g0wIaACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKACgAoAKAPor4h/F34j+D/GGgeHvC+qoLNtN011sntomWZ2UZUuV3gNwDhgfQipQHefEnS/hf4ZtrzxFN8M9K16xuNRaHxDdW8ga5sJHCneFwSM7gWAZCCynndkAHk9zrvjP4L/Edfh74R8UzDw9eX9tdQJJDFKHhn2dGdWI4JUlSMld2BmgDifjf/yVjxP/ANfzf+gimgOHpgFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAeqfHO8m07x/ouoW5AltdH02aPPTcqAj9RUoD2Lwze+FtV8S33xM0bxvokfhnxLaBfEehapIqtFII9p+UnGfXcCGDPgkMMAHn/xp0a9X4reGfFVoIZvDuqHT00m5tzuj8tNnyE9jyWHqrDHIbB0A4H43/wDJWPE//X83/oIpoDh6YBQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFAHt037QPgnUYrU698EdL1S6traK1NzcXqM7KigDrASB7ZqbARf8Lw+GH/AEbzoP8A4Ex//I9OwHa+Afj38PfE+oab4D1f4c6foelNMHsiZ0nghut25DsMShMsW+cdGPPBJCaA8N+LF+2p/EnxHeMsAL6hKp8ibzo/lO3KvgZHHoKaA5OmAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQAUAFABQB//2Q=="
            let cm_btns = document.querySelectorAll(".start-camera");
            let click_btns = document.querySelectorAll(".click-photo");

            for (const elm of click_btns) {
                elm.addEventListener('click', handleiamges);
            }
            for (const elm of cm_btns) {
                elm.addEventListener('click', startcamera);
            }
            async function startcamera(e) {
                let type = e.target.getAttribute("image-type");
                let stream1 = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                });
                let video = document.querySelector(`#video${type}`);
                video.classList.toggle('d-none');
                document.getElementById('first-cam-opener').style.display = "none";
                document.getElementById('pic-taker').style.display = "block";
                console.log(video)
                video.srcObject = stream1;
            }
            function handleiamges(e) {
                let type = e.target.getAttribute("image-type");
                let canvas = document.querySelector(`#canvas-${type}`);
                let input = document.querySelector(`#${type}`);
                canvas.classList.toggle('d-none');
                input.value = canvas.toDataURL('image/jpeg')
                let video = document.querySelector(`#video${type}`);
                video.classList.toggle('d-none');
                document.getElementById('take-pic-words').innerHTML = "<?php echo trans('messages.take_pic_again')?>";
                // document.getElementById('preview-label').style.display="block";
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                let image_data_url = canvas.toDataURL('image/jpeg');
                // data url of the image
                if (sampleImage != image_data_url && image_data_url != '' && image_data_url != null) {
                    document.getElementById("{{$input->id}}").value = image_data_url;
                }
            }
        </script>
    @endpush
</div>
