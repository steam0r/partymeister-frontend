@extends('partymeister-frontend::layouts.frontend')

@section('main_content')
    <h1>
        <a href="{{route('frontend.entries.create')}}" class="float-right btn btn-sm btn-success">Upload entry</a>
        Your entries
    </h1>
    @if ($entries->count() == 0)
        <div class="alert alert-warning">
            You haven't uploaded any entries yet!
        </div>
    @endif
    <div class="row">
        @foreach ($entries as $entry)
            <div class="col-md-6">
                <div class="card">
                    @if($entry->getFirstMedia('screenshot'))
                        <div class="image-wrapper">
                            <a data-caption="{{$entry->title}} by {{$entry->author}}" data-fancybox="gallery"
                               href="{{$entry->getFirstMedia('screenshot')->getUrl('preview')}}">
                                <img src="{{$entry->getFirstMedia('screenshot')->getUrl('preview')}}" class="img-fluid"
                                     style="position: absolute; top: 0; width: 100%;">
                            </a>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{$entry->title}} by {{$entry->author}}</h5>
                        <h6>{{$entry->competition->name}}</h6>
                        <p class="card-text">{{$entry->description}}</p>
                        <div class="btn-group d-flex justify-content-center">
                            @if ($entry->competition->upload_enabled || $entry->upload_enabled)
                                <a href="{{route('frontend.entries.edit', ['entry' => $entry])}}"
                                   class="btn btn-sm btn-primary">Edit</a>
                            @endif
                            @if ($entry->competition->competition_type->has_screenshot)
                                <a href="{{route('frontend.entries.screenshot.edit', ['entry' => $entry])}}"
                                   class="btn btn-sm btn-primary">Update screenshot</a>
                            @endif
                            <a href="{{route('frontend.entries.show', ['entry' => $entry])}}"
                               class="btn btn-sm btn-primary">Show</a>
                        </div>
                        <a href="{{route('frontend.comments.index', ['entry' => $entry])}}"
                           class="mt-3 btn btn-sm btn-block @if ($entry->new_comments > 0)btn-secondary @else btn-primary @endif">Messages @if ($entry->new_comments > 0)
                                ({{$entry->new_comments}} NEW) @endif</a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
