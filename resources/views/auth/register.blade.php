@extends('partymeister-frontend::layouts.frontend')

@section('main_content')
    <h1>Registration</h1>
    {!! form_start($form, ['id' => 'category-item']) !!}
    {!! form_until($form, 'submit') !!}
    {!! form_end($form) !!}
@endsection
