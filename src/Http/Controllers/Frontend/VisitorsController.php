<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Partymeister\Core\Models\Visitor;
use Partymeister\Frontend\Forms\Frontend\LoginForm;

class VisitorsController extends Controller
{

	use FormBuilderTrait;

    protected $visitor;


    public function index()
    {
        $visitor = Auth::guard('visitor')->user();
        $navHighlight = 'visitors';

        $visitors = Visitor::orderBy('created_at', 'DESC')->get();

		return view('partymeister-frontend::frontend.visitors', compact('visitors', 'visitor', 'navHighlight'));
    }

}