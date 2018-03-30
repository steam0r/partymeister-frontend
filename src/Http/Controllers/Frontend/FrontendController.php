<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Partymeister\Frontend\Forms\Frontend\LoginForm;

class FrontendController extends Controller
{

	use FormBuilderTrait;

    protected $visitor;


    public function index()
    {
        $visitor = Auth::guard('visitor')->user();
        $navHighlight = 'home';

		$loginForm      = $this->form(LoginForm::class, [
			'method'  => 'POST',
			'route'   => 'login',
			'enctype' => 'multipart/form-data'
		]);

		return view('partymeister-frontend::frontend.home', compact('loginForm', 'visitor', 'showLogin', 'navHighlight'));
    }

}