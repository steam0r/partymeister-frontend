<h1>Registration</h1>
<form action="{{ url('/login') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="input-group mb-3">
        <input type="text" name="email" class="form-control" placeholder="{{ trans('motor-backend::backend/users.email') }}">
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
