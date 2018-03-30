@extends('partymeister-frontend::layouts.frontend')
@section('view_styles')
    <link href="/css/jquery.raty.css" rel="stylesheet" type="text/css"/>
@append

@section('main_content')
    <h1>
        Voting
    </h1>
    @if ($votingDeadlineOver)
        <div class="alert alert-warning">
            Voting deadline is over!
        </div>
    @endif
    @if (is_null($competition))
        <div class="alert alert-warning">
            There are no entries to vote for yet!
        </div>
    @else
        <form id="save-votes" action="{{ route('frontend.votes.store')}}?competition_id={{$competition->id}}"
              method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h3>{{$competition->name}}</h3>
            <div class="row mb-5 entries">
                @foreach ($competition->entries()->where('status', 1)->orderBy('sort_position', 'ASC')->get() as $entry)
                    <div class="col-md-6">
                        <div class="card mb-3 @if(isset($votes[1][$entry->id]) && $votes[1][$entry->id]['special_vote'] == 1) special-vote-highlight @endif" data-entry-id="{{$entry->id}}">
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
                                    <div class="points" data-entry-id="{{$entry->id}}"
                                         data-vote-category-id="{{$voteCategory->id}}"></div>
                                    <input type="hidden" data-entry-id="{{$entry->id}}"
                                           data-vote-category-id="{{$voteCategory->id}}"
                                           name="entry[{{$competition->id}}][{{$voteCategory->id}}][{{$entry->id}}]"
                                           value="{{ (isset($votes[$voteCategory->id][$entry->id]) ? $votes[$voteCategory->id][$entry->id]['points'] : 0)}}">
                                    @if ($loop->last)
                                        <input @if ($votingDeadlineOver)disabled @endif type="text" class="entry-comment" placeholder="Comment"
                                               name="entry_comment[{{$competition->id}}][{{$entry->id}}]"
                                               value="{{ (isset($votes[$voteCategory->id][$entry->id]) ? $votes[$voteCategory->id][$entry->id]['comment'] : '')}}">
                                        <button class="btn btn-sm btn-success save-comment float-right">Send</button>

                                        <div>
                                            <button class="btn btn-sm btn-success btn-block special-vote-on @if(isset($votes[$voteCategory->id][$entry->id]) && $votes[$voteCategory->id][$entry->id]['special_vote'] == 1) d-none @endif">
                                                &hearts; My party
                                                favourite &hearts;
                                            </button>
                                            <button class="btn btn-sm btn-warning btn-block special-vote-off @if (!isset($votes[$voteCategory->id][$entry->id]) || $votes[$voteCategory->id][$entry->id]['special_vote'] == 0)d-none @endif">
                                                &#x2639; Not my
                                                favourite anymore &#x2639;
                                            </button>
                                        </div>
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
    @if (count($allCompetitions) > 0)
        <h2 class="pt-5">Please choose a competition</h2>
        <ul class="nav flex-column nav-pills">
            @foreach ($allCompetitions as $competition)
                <li class="nav-item">
                    <a class="nav-link" href="{{route('frontend.votes.index')}}?competition_id={{$competition->id}}">
                        {{$competition->name}}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
@if (!is_null($competition))
@section('view_scripts')
    <script src="js/jquery.raty.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.special-vote-on').on('click', function (e) {
                e.preventDefault();

                var ratingElement = $(this).parent().parent().find('.points');
                vote($(ratingElement).raty('score'), ratingElement, true);

                $('.special-vote-off').each(function (index, element) {
                    if (!$(element).hasClass('d-none')) {
                        $(element).addClass('d-none');
                        $(element).parent().find('.special-vote-on').removeClass('d-none');
                    }
                });
                $('.special-vote-off').addClass('d-none');

                $('.entries div .card').removeClass('special-vote-highlight');
                $(this).parent().parent().parent().addClass('special-vote-highlight');
                $(this).addClass('d-none');
                $(this).parent().find('.special-vote-off').removeClass('d-none');
            });

            $('.special-vote-off').on('click', function (e) {
                e.preventDefault();

                var ratingElement = $(this).parent().parent().find('.points');
                vote($(ratingElement).raty('score'), ratingElement, false);

                $('.entries div .card').removeClass('special-vote-highlight');
                $(this).addClass('d-none');
                $(this).parent().find('.special-vote-on').removeClass('d-none');
            });

            var vote = function (rating, element, specialVote) {
                var data = {
                    entry_id: $(element).data('entry-id'),
                    competition_id: {{$competition->id}},
                    vote_category_id: $(element).data('vote-category-id'),
                    points: rating,
                    comment: $(element).parent().find('input[type="text"]').val(),
                };


                if (specialVote != undefined) {
                    data.special_vote = specialVote;
                }

                axios.post('{{route('ajax.votes.submit', ['api_token' => $visitor->api_token])}}', data).then(function (response) {
                    if (response.data.success) {
                        $.toast(
                            {
                                text : response.data.message,
                                position: 'top-right'
                            });
                    } else if (response.data.error) {
                        $.toast(
                            {
                                text : response.data.message,
                                position: 'top-right',
                                bgColor: 'red',
                            });
                    }
                });
            };

            $('.save-comment').on('click', function(e) {
                e.preventDefault();
                var ratingElement = $(this).parent().find('.points');
                vote($(ratingElement).raty('score'), ratingElement);
            });

            $('.points').each(function (index, element) {
                points = $(element).parent().find('input:hidden[data-vote-category-id="' + $(element).data('vote-category-id') + '"]').val();
                $(element).raty({
                    starType: 'i',
                    cancel: true,
                    @if ($votingDeadlineOver)
                    readOnly: true,
                    @endif
                    score: points,
                    click: function (points) {
                        vote(points, this);
                    }
                });
            });
        });
    </script>
@append
@endif