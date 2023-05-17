@if($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach(array_unique($errors->all()) as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
