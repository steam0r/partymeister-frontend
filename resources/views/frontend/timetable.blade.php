@extends('partymeister-frontend::layouts.frontend')

@section('main_content')
    <h1>
        Timetable
    </h1>
    @foreach ($days as $dayKey => $times)
        <h2>{{$dayKey}}</h2>
        <table class="table">
            @foreach ($times as $hourKey => $events)
                <tr>
                    <td width="10%">{{$hourKey}}</td>
                    <td>
                        <table class="table timetable">
                            @foreach($events as $event)
                            <tr>
                                <td style="border-top: none; width: 100px;">
                                    <span class="badge badge-secondary" style="color: black;background-color: {{$event['web_color']}}">{{$event['type']}}</span>
                                </td>
                                <td style="border-top: none;">
                                    {{$event['name']}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            @endforeach
        </table>
        {{--<div class="col-md-6">--}}
            {{--<span class="flag-icon flag-icon-{{strtolower($v->country_iso_3166_1)}}"></span>--}}
            {{--{{$v->name}} @if ($v->group != '') / {{$v->group}} @endif--}}
        {{--</div>--}}
    @endforeach
@endsection
