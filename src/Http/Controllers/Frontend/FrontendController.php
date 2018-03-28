<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{

    protected $visitor;


    public function index()
    {
        $this->visitor = Auth::guard('visitor')->user();

        return view('partymeister-frontend::layouts.frontend', [ 'visitor' => $this->visitor ]);
    }

}