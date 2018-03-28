<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend\Entries;

use Illuminate\Support\Facades\Auth;
use Motor\Backend\Http\Controllers\Controller;

use Partymeister\Competitions\Models\Entry;
use Partymeister\Competitions\Http\Requests\Backend\EntryRequest;
use Partymeister\Competitions\Services\EntryService;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Partymeister\Frontend\Forms\Frontend\Entry\ScreenshotForm;

class ScreenshotController extends Controller
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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $record)
    {
        $visitor = Auth::guard('visitor')->user();
        $form = $this->form(ScreenshotForm::class, [
            'method'  => 'PATCH',
            'url'     => route('frontend.entries.screenshot.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('partymeister-frontend::frontend.entries.screenshot.edit', compact('form', 'visitor', 'record'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EntryRequest $request, Entry $record)
    {
        $form = $this->form(ScreenshotForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        EntryService::updateWithForm($record, $request, $form);

        flash()->success(trans('partymeister-competitions::backend/entries.updated'));

        return redirect('entries');
    }
}
