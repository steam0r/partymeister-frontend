@if (isset($loginForm) && (!isset($showLogin) || $showLogin))
    @if (is_null($visitor))
        <h1>Login</h1>
        {!! form_start($loginForm) !!}
        {!! form_until($loginForm, 'password') !!}
        <div class="row">
            <div class="col-md-6">
                <button type="submit"
                        class="btn btn-primary px-4">{{ trans('motor-backend::backend/login.sign_in') }}</button>
                {{--<input type="checkbox" name="remember" id="remember"> <label--}}
                {{--for="remember">{{ trans('motor-backend::backend/login.remember') }}</label>--}}
            </div>
            <div class="col-md-6">
                <a href="{{route('register')}}">or register!</a>
            </div>
        </div>
        {!! form_end($loginForm) !!}
    @endif
@endif
@if (isset($visitor) && !is_null($visitor))
    <h2>Hello {{$visitor->name}}</h2>
    @if ($visitor->new_comments > 0)
        <div class="alert alert-warning">
            <a href="{{route('frontend.entries.index')}}">
                You have {{$visitor->new_comments}} new message(s) for your entries!
            </a>
        </div>
    @endif
    <form id="logout" action="{{ url('/visitor/logout') }}" method="POST" class="form-inline">
    <ul class="nav flex-column nav-pills">
        <li class="nav-item">
            <a class="nav-link" href="{{route('frontend.entries.index')}}"><i class="fa fa-cloud-upload-alt"></i>
                My entries</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('frontend.votes.index') }}"><i class="fa fa-trophy"></i>

                Vote for the compos</a>
        </li>
        {{--<li class="nav-item">--}}
            {{--<a class="nav-link" href="#"><i class="fa fa-comment"></i>--}}
                {{--Write a message</a>--}}
        {{--</li>--}}
        <li class="nav-item">
                {{ csrf_field() }}
                <a class="logout nav-link" href="#"><i
                            class="fa fa-lock"></i> {{ trans('motor-backend::backend/login.sign_out') }}</a>
        </li>
    </ul>
    </form>
@endif

@if (!isset($loginForm) && is_null($visitor))
    <h4>Want to log in?</h4>
    <a href="{{url('home')}}" class="btn btn-sm btn-primary">Take me there!</a>
@endif
@section('view_scripts')
    <script>
        $(document).ready(function () {
            $('.logout').on('click', function () {
                $('form#logout').submit();
            })
        });
    </script>
@append
