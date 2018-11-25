<?php

namespace Partymeister\Frontend\Forms\Component\Partymeister;

use Kris\LaravelFormBuilder\Form;
use Partymeister\Core\Models\Schedule;

class ScheduleForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('schedule_id', 'select', ['label' => trans('partymeister-core::backend/schedules.schedule'), 'choices' => Schedule::pluck('name', 'id')->toArray()]);
    }
}
