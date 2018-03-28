<?php

namespace Partymeister\Frontend\Forms\Frontend;

use Kris\LaravelFormBuilder\Form;

class RegisterForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', ['label' => trans('partymeister-core::backend/visitors.name'), 'rules' => 'required'])
            ->add('group', 'text', ['label' => trans('partymeister-core::backend/visitors.group')])
            ->add('access_key', 'text', ['label' => trans('partymeister-competitions::backend/access_keys.access_key'), 'rules' => 'required'])
            ->add('country_iso_3166_1', 'select', ['label' => trans('motor-backend::backend/global.address.country'), 'choices' => \Symfony\Component\Intl\Intl::getRegionBundle()->getCountryNames()])
            ->add('password', 'password', ['value' => '', 'label' => trans('motor-backend::backend/users.password'), 'rules' => 'required'])
            ->add('password_confirmation', 'password', ['value' => '', 'label' => trans('motor-backend::backend/users.password_confirm'), 'rules' => 'required'])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('partymeister-core::backend/visitors.save')]);
    }
}
