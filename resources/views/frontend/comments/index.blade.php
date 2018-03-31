@extends('partymeister-frontend::layouts.frontend')
@section('view_styles')
    <style type="text/css">
        .unread {
            background-color: #ff9fb1;
            color: #0a0a0a;
        }
    </style>
@endsection

@section('main_content')
    <h1>Messages for entry {{$record->name}}</h1>
    @if($comments->count() > 0)
        <div class="@boxWrapper box-primary">
            @foreach ($comments as $comment)
                <div class="@boxHeader with-border">
                    @if ($comment->author != '')
                        <div class="float-right">{{$comment->author}}
                            on {{date('Y-m-d H:i', strtotime($comment->created_at))}}</div>
                    @else
                        <div class="float-left">{{$visitor->name}}
                            on {{date('Y-m-d H:i', strtotime($comment->created_at))}}</div>
                    @endif
                </div>
                <div class="@boxBody @if(!$comment->read_by_visitor) unread @endif">
                    {!! nl2br($comment->message) !!}
                </div>
            @endforeach
        </div>
    @endif
    {!! form_start($form) !!}
    <div class="@boxWrapper box-primary">
        <div class="@boxBody">
            @if ($comments->where('read_by_visitor', false)->count() > 0)
                <p>
                    <button type="submit" class="btn btn-block btn-warning mark-as-read">Mark all as read</button>
                </p>
            @endif
            {!! form_row($form->message) !!}
            {!! form_row($form->mark_as_read) !!}
        </div>
        <div class="@boxFooter">
            {!! form_row($form->submit) !!}
        </div>
    </div>
    {!! form_end($form, false) !!}
@endsection
@section('view_scripts')
    <script>
        $(document).ready(function () {
            $('.mark-as-read').on('click', function (e) {
                $('input#mark_as_read').val(1);
            });
        });
    </script>
@append