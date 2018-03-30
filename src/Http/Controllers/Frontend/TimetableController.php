<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend;

use Carbon\Carbon;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Partymeister\Core\Models\Schedule;
use Partymeister\Core\Models\Visitor;
use Partymeister\Core\Services\ScheduleService;
use Partymeister\Frontend\Forms\Frontend\LoginForm;
use stdClass;

class TimetableController extends Controller
{

	use FormBuilderTrait;

    protected $visitor;


    public function index()
    {
        $visitor = Auth::guard('visitor')->user();
        $navHighlight = 'timetable';

		$data = fractal(Schedule::first(), \Partymeister\Core\Transformers\ScheduleTransformer::class)->toArray();

		$days = [];

		foreach (array_get($data, 'data.events.data') as $key => $event)
		{
			$date = Carbon::createFromTimestamp(strtotime(array_get($event, 'starts_at')));
			$dayKey = $date->format('l');
			$timeKey = $date->format('H:i');
			if (!isset($days[$dayKey]))
			{
				$days[$dayKey] = [];
			}

			if (!isset($days[$dayKey][$timeKey]))
			{
				$days[$dayKey][$timeKey] = [];
			}
			$days[$dayKey][$timeKey][] = [
				"web_color"   => array_get($event, 'event_type.data.web_color'),
				"slide_color" => array_get($event, 'event_type.data.slide_color'),
				"id"          => array_get($event, 'id'),
				"typeid"      => array_get($event, 'event_type_id'),
				"type"        => array_get($event, 'event_type.data.name'),
				"name"        => array_get($event, 'name'),
				"description" => "",
				"link"        => "",
				"starttime"   => $date->format('Y-m-d H:i'),
				"endtime"     => ""
			];
		}
		$items = new stdClass();
		foreach ($days as $dayKey => $day)
		{
			$items->{$dayKey} = $day;
		}

		return view('partymeister-frontend::frontend.timetable', compact('days', 'visitor', 'navHighlight'));
    }

}