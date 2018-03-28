@if (is_null($visitor))
<h1>Login</h1>
<form action="{{ url('/visitor/login') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="input-group mb-3">
        <input type="text" name="name" class="form-control" placeholder="{{ trans('motor-backend::backend/users.name') }}">
    </div>
    <div class="input-group mb-4">
        <input type="password" name="password" class="form-control" placeholder="{{ trans('motor-backend::backend/users.password') }}">
    </div>
    <div class="row">
        <div class="col-6">
            <input type="checkbox" name="remember" id="remember"> <label for="remember">{{ trans('motor-backend::backend/login.remember') }}</label>
        </div>
        <div class="col-6 text-right">
            <button type="submit" class="btn btn-primary px-4">{{ trans('motor-backend::backend/login.sign_in') }}</button>
        </div>
    </div>
</form>
@else
    <h2>Hello {{$visitor->name}}</h2>
    <ul class="nav flex-column nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="{{route('frontend.entries.index')}}"><i class="fa fa-cloud-upload-alt"></i>
                Upload Entries</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('frontend.votes.index') }}"><i class="fa fa-trophy"></i>

                 Vote for the competitions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa fa-comment"></i>
                Write a message</a>
        </li>
        <li class="nav-item">
            <form id="logout" action="{{ url('/visitor/logout') }}" method="POST" class="form-inline">
                {{ csrf_field() }}
                <a class="logout nav-link" href="#"><i class="fa fa-lock"></i> {{ trans('motor-backend::backend/login.sign_out') }}</a>
            </form>
        </li>
    </ul>
@endif
@section('view_scripts')
    <script>
        $(document).ready(function(){
            $('.logout').on('click', function() {
                $('form#logout').submit();
            })
        });
    </script>
@append