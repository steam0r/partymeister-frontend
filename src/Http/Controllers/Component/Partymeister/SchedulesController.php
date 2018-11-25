<?php

namespace Partymeister\Frontend\Http\Controllers\Component\Partymeister;

use Illuminate\Http\Request;
use Motor\CMS\Http\Controllers\Component\ComponentController;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Partymeister\Frontend\Forms\Component\Partymeister\ScheduleForm;
use Partymeister\Frontend\Models\Component\ComponentSchedule;
use Partymeister\Frontend\Services\Component\ScheduleService;

class SchedulesController extends ComponentController
{

    use FormBuilderTrait;


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->form = $this->form(ScheduleForm::class);

        return response()->json($this->getFormData('component.schedules.store'));
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
        $form = $this->form(ScheduleForm::class);

        if ( ! $form->isValid()) {
            // TODO validation
            //return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        ScheduleService::createWithForm($request, $form);

        return response()->json(['message' => trans('partymeister-frontend::component/schedules.created')]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ComponentSchedule $record)
    {
        $this->form = $this->form(ScheduleForm::class, [
            'model'   => $record
        ]);

        return response()->json($this->getFormData('component.schedules.update'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComponentSchedule $record)
    {
        $form = $this->form(ScheduleForm::class);

        // TODO validation

        ScheduleService::updateWithForm($record, $request, $form);

        return response()->json(['message' => trans('partymeister-frontend::component/schedules.updated')]);
    }
}
