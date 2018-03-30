<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Http\Requests\Backend\EntryRequest;
use Partymeister\Competitions\Models\Vote;
use Partymeister\Competitions\Models\VoteCategory;
use Partymeister\Competitions\Services\EntryService;
use Partymeister\Frontend\Forms\Frontend\EntryForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class VotesController extends Controller {

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
		$this->visitor = Auth::guard('visitor')->user();

		$votingDeadlineOver = FALSE;
		if (strtotime(config('partymeister-competitions-voting.deadline')) < time())
		{
			$votingDeadlineOver = TRUE;
		}

		if ($request->get('competition_id') > 0)
		{
			$competition = Competition::where('voting_enabled', TRUE)
				->where('id', $request->get('competition_id'))
				->orderBy('updated_at', 'ASC')
				->first();
		}
		else
		{
			$competition = Competition::where('voting_enabled', TRUE)->orderBy('updated_at', 'ASC')->first();
		}

		$votes = [];
		if (!is_null($competition))
		{
			foreach ($competition->vote_categories as $voteCategory)
			{
				if (!isset($votes[$voteCategory->id]))
				{
					$votes[$voteCategory->id] = [];
				}
			}
			foreach (Auth::guard('visitor')->user()->votes()->where('competition_id', $competition->id)->get() as $vote)
			{
				$votes[$vote->vote_category_id][$vote->entry_id] = [
					'points'       => $vote->points,
					'comment'      => $vote->comment,
					'special_vote' => $vote->special_vote
				];
			}
		}

		$allCompetitions = Competition::where('voting_enabled', TRUE)->orderBy('updated_at', 'ASC')->get();

		return view('partymeister-frontend::frontend.votes.index', [
			'visitor'            => $this->visitor,
			'entries'            => $this->visitor->entries,
			'competition'        => $competition,
			'allCompetitions'    => $allCompetitions,
			'votes'              => $votes,
			'votingDeadlineOver' => $votingDeadlineOver
		]);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$visitor = Auth::guard('visitor')->user();
		foreach ($request->get('entry', []) as $competitionId => $voteCategories)
		{
			foreach ($voteCategories as $voteCategoryId => $entries)
			{
				foreach ($entries as $entryId => $points)
				{

					$vote = $visitor->votes()
						->where('competition_id', $competitionId)
						->where('entry_id', $entryId)
						->where('vote_category_id', $voteCategoryId)
						->first();

					if (is_null($vote))
					{
						$vote = new Vote();
					}

					if ($points > 5)
					{
						$points = 5;
					}

					$vote->vote_category_id = $voteCategoryId;
					$vote->competition_id = $competitionId;
					$vote->entry_id = $entryId;
					$vote->comment = array_get($request->all(),
						'entry_comment.' . $competitionId . '.' . $entryId);
					$vote->points = $points;
					$vote->visitor_id = Auth::guard('visitor')->user()->id;
					$vote->ip_address = $request->ip();
					$vote->save();
				}
			}
		}

		flash()->success(trans('partymeister-competitions::backend/entries.created'));

		if ($request->get('competition_id', FALSE))
		{
			return redirect('votes?competition_id=' . $request->get('competition_id'));
		}
		else
		{
			return redirect('votes');
		}
	}

}
