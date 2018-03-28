@extends('partymeister-frontend::layouts.frontend')
@section('view_styles')
    <link href="/css/jquery.raty.css" rel="stylesheet" type="text/css"/>
@append

@section('main_content')
    <h1>
        <button class="save-votes float-right btn btn-sm btn-success">Save votes</button>
        Voting
    </h1>
    @if (is_null($competition))
        <div class="alert alert-warning">
            There are no entries to vote for yet!
        </div>
    @else
        <form id="save-votes" action="{{ route('frontend.votes.store')}}?competition_id={{$competition->id}}"
              method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h3>{{$competition->name}}</h3>
            <div class="row mb-5">
                @foreach ($competition->entries()->where('status', 1)->orderBy('sort_position', 'ASC')->get() as $entry)
                    <div class="col-md-6">
                        <div class="card mb-3" data-entry-id="{{$entry->id}}">
                            @if($entry->getFirstMedia('screenshot'))
                                <a data-caption="{{$entry->title}} by {{$entry->author}}" data-fancybox="gallery"
                                   href="{{$entry->getFirstMedia('screenshot')->getUrl('preview')}}">
                                    <img src="{{$entry->getFirstMedia('screenshot')->getUrl('preview')}}"
                                         class="img-fluid">
                                </a>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{$entry->title}} by {{$entry->author}}</h5>
                                <h6>{{$entry->competition->name}}</h6>
                                {{--<p class="card-text">{{$entry->description}}</p>--}}
                                {{--<span style="font-size: 25px;">&#x1f4a9;</span>--}}
                                @foreach($competition->vote_categories as $voteCategory)
                                    <div class="points" data-vote-category-id="{{$voteCategory->id}}"></div>
                                    <input type="hidden" data-vote-category-id="{{$voteCategory->id}}"
                                           name="entry[{{$competition->id}}][{{$voteCategory->id}}][{{$entry->id}}]"
                                           value="{{ (isset($votes[$voteCategory->id][$entry->id]) ? $votes[$voteCategory->id][$entry->id]['points'] : 0)}}">
                                    @if ($loop->last)
                                        <input type="text" name="entry_comment[{{$competition->id}}][{{$entry->id}}]"
                                               value="{{ (isset($votes[$voteCategory->id][$entry->id]) ? $votes[$voteCategory->id][$entry->id]['comment'] : '')}}">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    @endif
@endsection

@section('sidebar')
    <h2>Please choose a competition</h2>
    <ul class="nav flex-column nav-pills">
        @foreach ($allCompetitions as $competition)
            <li class="nav-item">
                <a class="nav-link" href="{{route('frontend.votes.index')}}?competition_id={{$competition->id}}">
                    {{$competition->name}}</a>
            </li>
        @endforeach
    </ul>
@endsection
@section('view_scripts')
    <script src="js/jquery.raty.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.save-votes').on('click', function (e) {
                e.preventDefault();
                $('.points').each(function (index, element) {
                    $(element).parent().find('input:hidden[data-vote-category-id="' + $(element).data('vote-category-id') + '"]').val($(element).raty('score'));
                    $('form#save-votes').submit();
                });
            });
            $('.points').each(function (index, element) {
                points = $(element).parent().find('input:hidden[data-vote-category-id="' + $(element).data('vote-category-id') + '"]').val();
                $(element).raty({
                    starType: 'i',
                    cancel: true,
                    readOnly: false,
                    score: points
                });
            });
        });
    </script>
@append
