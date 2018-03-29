<?php

namespace Partymeister\Frontend\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Partymeister\Competitions\Models\AccessKey;
use Partymeister\Core\Models\Visitor;
use Partymeister\Frontend\Forms\Frontend\RegisterForm;

class RegisterController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use FormBuilderTrait;

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';


    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('visitor');
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:visitor');
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $visitor   = null;
        $showLogin = false;
        $form      = $this->form(RegisterForm::class, [
            'method'  => 'POST',
            'route'   => 'register',
            'enctype' => 'multipart/form-data',
            'model'   => [ 'country_iso_3166_1' => 'DE' ]
        ]);

        return view('partymeister-frontend::auth.register', compact('form', 'visitor', 'showLogin'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'       => 'required|max:255|unique:visitors',
            //'email' => 'required|email|max:255|unique:users',
            'password'   => 'required|min:6|confirmed',
            'access_key' => [
                'required',
                'min:8',
                Rule::exists('access_keys')->where(function ($query) {
                    $query->where('visitor_id', null);
                })
            ]
        ]);
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($visitor = $this->create($request->all())));

        $this->guard('visitor')->login($visitor);

        return $this->registered($request, $visitor) ?: redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $visitor                  = Visitor::create([
            'name'               => $data['name'],
            'group'              => $data['group'],
            'country_iso_3166_1' => $data['country_iso_3166_1'],
            //'email'              => $data['email'],
            'password'           => bcrypt($data['password']),
            'api_token'          => str_random(60),
        ]);
        $accessKey                = AccessKey::where('access_key', $data['access_key'])->first();
        $accessKey->visitor_id    = $visitor->id;
        $accessKey->ip_address    = \Request::ip();
        $accessKey->registered_at = date('Y-m-d H:i:s');
        $accessKey->save();

        return $visitor;
    }
}
