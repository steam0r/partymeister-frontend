@extends('partymeister-frontend::layouts.frontend')
@section('view_styles')
    <link href="/css/jquery.raty.css" rel="stylesheet" type="text/css"/>
@append

@section('main_content')
    <h1>
        Releases
    </h1>
    @if (is_null($competition))
        <div class="alert alert-warning">
            There are no releases yet!
        </div>
    @endif
    @if (!is_null($competition))
            <h3>{{$competition->name}}</h3>
            <div class="row mb-5 entries">
                @foreach ($competition->entries()->where('status', 1)->orderBy('sort_position', 'ASC')->get() as $entry)
                    <div class="col-md-6">
                        <div class="card mb-3">
                            @if($entry->getFirstMedia('screenshot'))
                                <div class="image-wrapper">
                                    <a data-caption="{{$entry->title}} by {{$entry->author}}" data-fancybox="gallery"
                                       href="{{$entry->getFirstMedia('screenshot')->getUrl('preview')}}">
                                        <img src="{{$entry->getFirstMedia('screenshot')->getUrl('preview')}}"
                                             class="img-fluid" style="position: absolute; top: 0; width: 100%;">
                                    </a>
                                </div>
                            @endif
                                @if($entry->getFirstMedia('audio'))
                                    <audio controls src="{{$entry->getFirstMedia('audio')->getUrl()}}" style="width: 100%"></audio>
                                @endif
                            <div class="card-body">
                                <h5 class="card-title">{{$entry->title}} by {{$entry->author}}</h5>
                                <h6>{{$entry->competition->name}}</h6>
                                @if ($entry->download != null)
                                    <div class="clearfix"></div>
                                <a href="{{$entry->download->getUrl()}}" style="text-decoration: none !important">
                                    <button type="button" class="btn btn-sm btn-block btn-success mt-3">
                                        Download
                                    </button>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    @endif
@endsection

@section('sidebar')
    @if (count($allCompetitions) > 0)
        <h2 class="pt-5">Please choose a competition</h2>
        <ul class="list-unstyled flex-column nav-pills">
            @foreach ($allCompetitions as $c)
                <li>
                    <a href="{{route('frontend.releases.index')}}?competition_id={{$c->id}}">
                        {{$c->name}}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection