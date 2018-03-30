<?php

namespace Partymeister\Frontend\Forms\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Input;
use Kris\LaravelFormBuilder\Form;
use Partymeister\Competitions\Models\Competition;
use Partymeister\Competitions\Models\Entry;

class EntryForm extends Form
{
    public function buildForm()
    {
        $competitions = Competition::orderBy('sort_position')->where('upload_enabled', true)->pluck('name', 'id')->toArray();

        $data = [];
        // FIXME: something is not great here with setting the competition-id
        if (Input::old('competition_id')) {
            $data['competition'] = Competition::find(Input::old('competition_id'));
            $this->add('competition_id', 'select', ['attr' => ['class' => 'form-control reload-on-change'], 'label' => trans('partymeister-competitions::backend/competitions.competition'), 'empty_value' => trans('motor-backend::backend/global.please_choose'), 'choices' => $competitions]);
        } elseif (is_object($this->getModel()) && $this->getModel()->competition_id > 0) {
            $data['competition'] = Competition::find($this->getModel()->competition_id);
            $this->add('competition_id', 'static', ['attr' => ['class' => 'form-control reload-on-change'], 'label' => trans('partymeister-competitions::backend/competitions.competition'), 'empty_value' => trans('motor-backend::backend/global.please_choose')]);
        } else {
            $this->add('competition_id', 'select', ['attr' => ['class' => 'form-control reload-on-change'], 'label' => trans('partymeister-competitions::backend/competitions.competition'), 'empty_value' => trans('motor-backend::backend/global.please_choose'), 'choices' => $competitions]);
        }

        $this
            ->add('reload_on_change', 'hidden', ['attr' => ['id' => 'reload_on_change']])
            ->add('title', 'text', ['label' => trans('partymeister-competitions::backend/entries.title'), 'rules' => 'required'])
            ->add('author', 'text', ['label' => trans('partymeister-competitions::backend/entries.author'), 'rules' => 'required'])
            ->add('description', 'textarea', ['label' => trans('partymeister-competitions::backend/entries.description')])
            ->add('organizer_description', 'textarea', ['label' => trans('partymeister-competitions::backend/entries.organizer_description')])
            ->add('custom_option', 'text', ['label' => trans('partymeister-competitions::backend/entries.custom_option')])

            ->add('author_name', 'text', ['label' => trans('partymeister-competitions::backend/entries.name'), 'rules' =>  'required'])
            ->add('author_email', 'email', ['label' => trans('partymeister-competitions::backend/entries.email'), 'rules' =>  ['required']])
            ->add('author_phone', 'text', ['label' => trans('partymeister-competitions::backend/entries.phone'), 'rules' =>  'required'])
            ->add('author_address', 'text', ['label' => trans('partymeister-competitions::backend/entries.address'), 'rules' =>  'required'])
            ->add('author_zip', 'text', ['label' => trans('partymeister-competitions::backend/entries.zip'), 'rules' =>  'required'])
            ->add('author_city', 'text', ['label' => trans('partymeister-competitions::backend/entries.city'), 'rules' =>  'required'])
            ->add('author_country_iso_3166_1', 'select', ['label' => trans('partymeister-competitions::backend/entries.country'), 'default_value' => 'DE', 'choices' => \Symfony\Component\Intl\Intl::getRegionBundle()->getCountryNames()])
            ->add('options', 'form', ['wrapper' => [], 'class' => '\Partymeister\Competitions\Forms\Backend\EntryOptionForm', 'label' => false, 'data' => $data])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary btn-block'], 'label' => trans('partymeister-competitions::backend/entries.save')]);
        $rules = 'required';
        if ($this->getModel() instanceof Entry) {
        	$rules = '';
		}
        $this
            ->add('file', 'file_file', ['label' =>  trans('partymeister-competitions::backend/entries.file'), 'model' => Entry::class, 'rules' => $rules]);

        if (isset($data['competition'])) {
            if ($data['competition']->competition_type->has_screenshot) {
                for($i=1; $i<=$data['competition']->competition_type->number_of_work_stages; $i++) {
                    $this->add('work_stage_'.$i, 'file_image', ['label' =>  trans('partymeister-competitions::backend/entries.work_stage').' '.$i, 'model' => Entry::class, 'rules' => $rules]);
                }
            }
            if ($data['competition']->competition_type->has_screenshot) {
                $this->add('screenshot', 'file_image', ['label' =>  trans('partymeister-competitions::backend/entries.screenshot'), 'model' => Entry::class]);
            }
            if ($data['competition']->competition_type->has_video) {
                $this->add('video', 'file_video', ['label' =>  trans('partymeister-competitions::backend/entries.video'), 'model' => Entry::class]);
            }
//            if ($data['competition']->competition_type->has_audio) {
//                $this->add('audio', 'file_audio', ['label' =>  trans('partymeister-competitions::backend/entries.audio'), 'model' => Entry::class]);
//            }
//            if ($data['competition']->competition_type->has_running_time) {
//                $this->add('running_time', 'text', ['label' => trans('partymeister-competitions::backend/entries.running_time')]);
//            }

            if ($data['competition']->competition_type->has_composer) {
                $this->add('composer_name', 'text', ['label' => trans('partymeister-competitions::backend/entries.name'), 'rules' =>  'required'])
                    ->add('composer_email', 'email', ['label' => trans('partymeister-competitions::backend/entries.email'), 'rules' =>  ['required']])
                    ->add('composer_phone', 'text', ['label' => trans('partymeister-competitions::backend/entries.phone'), 'rules' =>  'required'])
                    ->add('composer_address', 'text', ['label' => trans('partymeister-competitions::backend/entries.address'), 'rules' =>  'required'])
                    ->add('composer_zip', 'text', ['label' => trans('partymeister-competitions::backend/entries.zip'), 'rules' =>  'required'])
                    ->add('composer_city', 'text', ['label' => trans('partymeister-competitions::backend/entries.city'), 'rules' =>  'required'])
                    ->add('composer_country_iso_3166_1', 'select', ['label' => trans('partymeister-competitions::backend/entries.country'), 'default_value' => 'DE', 'choices' => \Symfony\Component\Intl\Intl::getRegionBundle()->getCountryNames()]);
            }
        }
    }
}
