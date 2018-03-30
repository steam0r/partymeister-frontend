@extends('partymeister-frontend::layouts.frontend')

@section('main_content')
    <h1>
        Who's here?
    </h1>
    @foreach ($visitors as $v)
        <div class="col-md-6">
            <span class="flag-icon flag-icon-{{strtolower($v->country_iso_3166_1)}}"></span>
            {{$v->name}} @if ($v->group != '') / {{$v->group}} @endif
        </div>
    @endforeach
@endsection
