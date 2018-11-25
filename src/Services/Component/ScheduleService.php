<?php

namespace Partymeister\Frontend\Services\Component;

use Motor\CMS\Services\Component\ComponentService;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Frontend\Models\Component\ComponentSchedule;

class   ScheduleService extends ComponentService
{

    protected $model = ComponentSchedule::class;

    protected $name = 'schedule';

    public function beforeCreate()
    {
    }


    public function afterCreate()
    {
        // Create the page component
        $pageComponent                  = new PageVersionComponent();
        $pageComponent->page_version_id = $this->request->get('page_version_id');
        $pageComponent->container       = $this->request->get('container');
        $pageComponent->component_name  = $this->name;
        $pageComponent->sort_position   = PageVersionComponent::where('page_version_id',
                $this->request->get('page_version_id'))->where('container',
                $this->request->get('container'))->count() + 1;
        $this->record->component()->save($pageComponent);
    }


    public function afterUpdate()
    {
    }


    public function beforeDelete()
    {
        $this->record->component()->delete();
    }


    public function beforeUpdate()
    {

    }
}
