<div class="container">
    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            <div class="alert alert-danger mt-2" role="alert">{{$error}}</div>
        @endforeach
    @endif

    @if(session('success'))
        <div class="alert alert-success mt-2" role="alert">{{session('success')}}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-2" role="alert">{{session('error')}}</div>
    @endif
</div>