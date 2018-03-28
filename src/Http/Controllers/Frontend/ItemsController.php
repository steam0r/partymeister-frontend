<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Partymeister\Accounting\Models\ItemType;
use Partymeister\Accounting\Transformers\ItemTypeTransformer;

class ItemsController extends Controller
{

    protected $visitor;


    public function index()
    {
        $this->visitor = Auth::guard('visitor')->user();

        $itemTypes = ItemType::where('is_visible', true)->orderBy('sort_position', 'ASC')->get();

        return view('partymeister-frontend::frontend.items.index',
            [ 'visitor' => $this->visitor, 'itemTypes' => $itemTypes ]);
    }

}