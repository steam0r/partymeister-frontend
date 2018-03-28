@extends('partymeister-frontend::layouts.frontend')

@section('main_content')
    <h1>Your entries</h1>
    @if ($entries->count() == 0)
        <div class="alert alert-warning">
            <a href="{{route('frontend.entries.create')}}" class="float-right btn btn-sm btn-success">Upload entry</a>
            You haven't uploaded any entries yet!
        </div>
    @endif
    @foreach ($entries as $entry)
        <div class="card col-md-6">
            @if($entry->getFirstMedia('screenshot'))
                <a data-caption="{{$entry->title}} by {{$entry->author}}" data-fancybox="gallery" href="{{$entry->getFirstMedia('screenshot')->getUrl('preview')}}">
                    <img src="{{$entry->getFirstMedia('screenshot')->getUrl('preview')}}" class="img-fluid">
                </a>
            @endif
            <div class="card-body">
                <h5 class="card-title">{{$entry->title}} by {{$entry->author}}</h5>
                <h6>{{$entry->competition->name}}</h6>
                <p class="card-text">{{$entry->description}}</p>
                <div class="btn-group">
                    @if ($entry->competition->upload_enabled)
                    <a href="{{route('frontend.entries.edit', ['entry' => $entry])}}" class="btn btn-primary">Edit</a>
                    @endif
                    @if ($entry->competition->competition_type->has_screenshot)
                        <a href="{{route('frontend.entries.screenshot.edit', ['entry' => $entry])}}" class="btn btn-primary">Update screenshot</a>
                    @endif
                    <a href="#" class="btn btn-primary">Comment</a>
                </div>
            </div>
        </div>
    @endforeach
@endsection
