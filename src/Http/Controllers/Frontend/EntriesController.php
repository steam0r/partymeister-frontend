<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;
use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Http\Requests\Backend\EntryRequest;
use Partymeister\Competitions\Services\EntryService;
use Partymeister\Frontend\Forms\Frontend\EntryForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Partymeister\Slides\Models\SlideTemplate;

class EntriesController extends Controller
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
    public function index()
    {
        $this->visitor = Auth::guard('visitor')->user();

        return view('partymeister-frontend::frontend.entries.index', ['visitor' => $this->visitor, 'entries' => $this->visitor->entries]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EntryRequest $request)
    {
        $visitor = Auth::guard('visitor')->user();
        $form = $this->form(EntryForm::class, [
            'method' => 'POST',
            'route' => 'frontend.entries.store',
            'enctype' => 'multipart/form-data',
//			'model' => ['author_country_iso_3166_1' => 'DE', 'composer_country_iso_3166_1' => 'DE']
        ]);

        return view('partymeister-frontend::frontend.entries.create', compact('form', 'visitor'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EntryRequest $request)
    {
        $form = $this->form(EntryForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ((int)$request->get('reload_on_change') == 1) {
            return redirect()->back()->withInput();
        }
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        EntryService::createWithForm($request, $form);

        flash()->success(trans('partymeister-competitions::backend/entries.created'));

        return redirect('entries');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $record)
    {
        $visitor = Auth::guard('visitor')->user();
        if ($visitor->id != $record->visitor_id) {
            return redirect('home');
        }

        $data = fractal($record,
            \Partymeister\Competitions\Transformers\EntryTransformer::class)->toArray();

        $entry = $data['data'];


        $entry['competition_name'] = strtoupper($entry['competition_name']);
        if ($entry['filesize_bytes'] == 0) {
            $entry['filesize_human'] = ' ';
        }
        if ($entry['description'] == '') {
            $entry['description'] = ' ';
        }
        $entry['description'] = nl2br($entry['description']);
        $entry['sort_position_prefixed'] = rand(10, 99);
        $entry['previous_sort_position'] = ' ';
        $entry['previous_author'] = ' ';
        $entry['previous_title'] = ' ';


        $competitionTemplate = SlideTemplate::where('template_for', 'competition')->first();
        return view('partymeister-frontend::frontend.entries.show', compact('form', 'visitor', 'record', 'competitionTemplate', 'entry'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $record)
    {
        if (!$record->competition->upload_enabled && !$record->upload_enabled) {
            return redirect('entries');
        }
        $visitor = Auth::guard('visitor')->user();
        $form = $this->form(EntryForm::class, [
            'method' => 'PATCH',
            'url' => route('frontend.entries.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model' => $record
        ]);

        return view('partymeister-frontend::frontend.entries.edit', compact('form', 'visitor', 'record'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EntryRequest $request, Entry $record)
    {
        if (!$record->competition->upload_enabled && !$record->upload_enabled) {
            return redirect('entries');
        }
        $form = $this->form(EntryForm::class);

        $form->getField('file')->setOption('rules', '');
//        if ($record->competition->competition_type->number_of_work_stages > 0) {
//            for ($i = 1; $i <= $record->competition->competition_type->number_of_work_stages; $i++) {
////                $form->getField('work_stage_' . $i)->setOption('rules', '');
//            }
//        }

        // It will automatically use current request, get the rules, and do the validation
        if ((int)$request->get('reload_on_change') == 1) {
            return redirect()->back()->withInput();
        }

        // It will automatically use current request, get the rules, and do the validation
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        EntryService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-competitions::backend/entries.updated'));

        return redirect('entries');
    }
}
