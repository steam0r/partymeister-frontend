<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Motor\Backend\Http\Controllers\Controller;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class LiveVotingController extends Controller
{

    use FormBuilderTrait;

    protected $visitor;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:visitor');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $visitor = Auth::guard('visitor')->user();

        if (is_null($visitor)) {
            return redirect('home');
        }

        return view('partymeister-frontend::frontend.livevoting.index', compact('visitor'));
    }
}
