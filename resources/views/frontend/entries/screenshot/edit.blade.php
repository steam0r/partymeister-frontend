@extends('partymeister-frontend::layouts.frontend')

@section('main_content')
    @include('motor-backend::errors.list')
    @include('partymeister-frontend::frontend.entries.screenshot.form')
@endsection