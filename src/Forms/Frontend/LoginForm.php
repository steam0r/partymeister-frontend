<?php

namespace Partymeister\Frontend\Forms\Frontend;

use Kris\LaravelFormBuilder\Form;

class LoginForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => trans('partymeister-core::backend/visitors.name'), 'rules' => 'required'])
			->add('password', 'password', ['label' => trans('motor-backend::backend/users.password'), 'rules' => 'required']);
    }
}
