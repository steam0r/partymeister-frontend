@extends('partymeister-frontend::layouts.frontend')

@section('main_content')
    <h1>
        Welcome to Revision 2018!
    </h1>
    <p>
        Sit down, unpack, have a beer, code, Code, CODE!
    </p>
    <h2>Paintover Announcement</h2>
    <p>
        Compo Deadline in 24 hours, Sunday at 14:00 / You don't have to use the colors. / <a href="http://s458562533.online.de/pofc--2018/">Example Execution</a>
    </p>
    <img src="{{asset('images/paintover2018_yourname_step01.png')}}" class="img-fluid">

    <div class="clearfix">

    </div>
    <p></p>

    <div class="alert alert-warning">
        Small disclaimer. The party system is currently being rewritten and is missing some features - but we'll get
        there. Promise!
    </div>
@endsection
