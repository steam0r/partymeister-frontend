<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend\Entries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Motor\Backend\Http\Controllers\Controller;
use Partymeister\Competitions\Models\Comment;
use Partymeister\Competitions\Models\Entry;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Partymeister\Core\Services\StuhlService;
use Partymeister\Frontend\Forms\Frontend\CommentForm;

class CommentsController extends Controller
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


    public function index(Entry $record)
    {
        $visitor = Auth::guard('visitor')->user();

        if ($visitor->id != $record->visitor_id) {
            return redirect('home');
        }

        $form    = $this->form(CommentForm::class, [
            'method'  => 'POST',
            'url'     => route('frontend.comments.store', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        $comments = $record->comments;

        return view('partymeister-frontend::frontend.comments.index', compact('form', 'visitor', 'record', 'comments'));
    }

    public function store(Request $request, Entry $record)
    {
        $visitor = Auth::guard('visitor')->user();
        $form = $this->form(CommentForm::class);

        if ($visitor->id != $record->visitor_id) {
            return redirect('home');
        }

        if ($request->get('mark_as_read') == 1) {
            foreach ($record->comments()->get() as $comment) {
                $comment->read_by_visitor = true;
                $comment->save();
            }
            return redirect('comments/'.$record->id);
        } else {
            $form->getField('message')->setOption('rules', ['required']);
        }

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        foreach ($record->comments()->get() as $comment) {
            $comment->read_by_visitor = true;
            $comment->save();
        }

        $c = new Comment();
        $c->visitor_id = $visitor->id;
        $c->read_by_visitor = true;
        $c->model_type = get_class($record);
        $c->model_id = $record->id;
        $c->message = $request->get('message');
        $c->save();

        StuhlService::send($visitor->name.' just wrote a comment for his entry '.$record->name. ' in the '. $record->competition->name. ' competition!');

        return redirect('comments/'.$record->id);
    }
}
