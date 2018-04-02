<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Http\Requests\Backend\EntryRequest;
use Partymeister\Competitions\Models\LiveVote;
use Partymeister\Competitions\Models\Vote;
use Partymeister\Competitions\Models\VoteCategory;
use Partymeister\Competitions\Services\EntryService;
use Partymeister\Frontend\Forms\Frontend\EntryForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class ReleasesController extends Controller
{

    protected $visitor;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->visitor = Auth::guard('visitor')->user();

        if ($request->get('competition_id') > 0) {
            $competition = Competition::where('voting_enabled', TRUE)
                ->where('id', $request->get('competition_id'))
                ->orderBy('updated_at', 'ASC')
                ->first();
        } else {
            $competition = Competition::where('voting_enabled', TRUE)->orderBy('updated_at', 'ASC')->first();
        }

        $votes = [];

        $allCompetitions = Competition::where('voting_enabled', TRUE)->orderBy('updated_at', 'ASC')->get();

        return view('partymeister-frontend::frontend.releases.index', [
            'visitor' => $this->visitor,
            'competition' => $competition,
            'allCompetitions' => $allCompetitions,
            'navHighlight' => 'releases'
        ]);
    }
}
