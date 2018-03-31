<?php

namespace Partymeister\Frontend\Forms\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Input;
use Kris\LaravelFormBuilder\Form;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;

class CommentForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('message', 'textarea', ['label' => 'Message'])
            ->add('mark_as_read', 'hidden', ['attr' => ['id' => 'mark_as_read']])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary btn-block'], 'label' => 'Send']);
    }
}
