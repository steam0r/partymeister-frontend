<?php

namespace Partymeister\Frontend\Components\Partymeister;

use Illuminate\Http\Request;
use Motor\CMS\Models\PageVersionComponent;
use Partymeister\Accounting\Models\ItemType;

class ItemList {

    protected $pageVersionComponent;

    protected $itemTypes;

    public function __construct(PageVersionComponent $pageVersionComponent)
    {
        $this->pageVersionComponent = $pageVersionComponent;
    }

    public function index(Request $request)
    {
        $this->itemTypes = ItemType::where('is_visible', true)->orderBy('sort_position', 'ASC')->get();

        return $this->render();
    }


    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), ['itemTypes' => $this->itemTypes]);
    }

}