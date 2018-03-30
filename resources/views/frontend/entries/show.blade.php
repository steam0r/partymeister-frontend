@extends('partymeister-frontend::layouts.frontend')

@section('main_content')
    @include('motor-backend::errors.list')
    <h1>
        @if ($record->is_remote)
            <span class="badge badge-danger">REMOTE</span>
        @endif
        {{$record->title}} by {{$record->author}}
    </h1>

    <div class="row">
        <div class="col-md-12">
            <dl class="row">
                <dt class="col-sm-4">
                    ID
                </dt>
                <dd class="col-sm-8">
                    {{ $record->id }}
                </dd>

                <dt class="col-sm-4">
                    {{trans('partymeister-competitions::backend/competitions.competition')}}
                </dt>
                <dd class="col-sm-8">
                    {{ $record->competition->name }}
                </dd>

                @if($record->competition->competition_type->has_running_time)
                    <dt class="col-sm-4">
                        {{trans('partymeister-competitions::backend/entries.running_time')}}
                    </dt>
                    <dd class="col-sm-8">
                        {{ $record->running_time }}
                    </dd>
                @endif

                <dt class="col-sm-4">
                    {{trans('partymeister-competitions::backend/entries.description')}}
                </dt>
                <dd class="col-sm-8">
                    <p>{{nl2br($record->description)}}</p>
                </dd>

                <dt class="col-sm-4">
                    {{trans('partymeister-competitions::backend/entries.organizer_description')}}
                </dt>
                <dd class="col-sm-8">
                    <p>{{nl2br($record->organizer_description)}}</p>
                </dd>
            </dl>
        </div>
        <div class="col-sm-6">
            <dl class="row">
                @if ($record->options->count() > 0)
                    <dt class="col-sm-4">
                        {{trans('partymeister-competitions::backend/entries.option_info')}}
                    </dt>
                    <dd class="col-sm-8">
                        <ul class="list-unstyled">
                            @foreach ($record->options as $option)
                                <li>{{$option->name}}</li>
                            @endforeach
                        </ul>
                    </dd>
                @endif
                <dt class="col-sm-4">
                    {{trans('partymeister-competitions::backend/entries.custom_option_short')}}
                </dt>
                <dd class="col-sm-8">
                    {{ $record->custom_option }}
                </dd>
                {{--<template v-if="$record->files.data">--}}
                {{--<dt class="col-sm-4">--}}
                {{--{{trans('partymeister-competitions::backend/entries.file_info')}}--}}
                {{--</dt>--}}
                {{--<dd class="col-sm-8">--}}
                {{--<ul class="list-unstyled">--}}
                {{--<li v-for="(file, index) in $record->files.data" style="margin-bottom: 5px;">--}}
                {{--{{trans('motor-backend::backend/global.uploaded')}} {{ file.created_at }}<br>--}}
                {{--<a :href="file.url">{{ file.file_name }}</a>--}}
                {{--</li>--}}
                {{--</ul>--}}
                {{--</dd>--}}
                {{--</template>--}}

            </dl>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-12 mb-5">
            <h3>Screenshot</h3>
            <div class="card">
                @if($record->getFirstMedia('screenshot'))
                    <a data-caption="{{$record->title}} by {{$record->author}}" data-fancybox="gallery"
                       href="{{$record->getFirstMedia('screenshot')->getUrl('preview')}}">
                        <img src="{{$record->getFirstMedia('screenshot')->getUrl('preview')}}" class="img-fluid">
                    </a>
                @endif
            </div>
        </div>
        @if ($record->competition->competition_type->number_of_work_stages > 0)
            <div class="col-md-12 mb-5">
                <h3>Work stages</h3>
                <div class="row">
                    @for ($i=1; $i<=$record->competition->competition_type->number_of_work_stages; $i++)
                        <div class="col-md-6">
                            <div class="card">
                                @if($record->getFirstMedia('work_stage_'.$i))
                                    <a data-caption="Work stage {{$i}}" data-fancybox="gallery"
                                       href="{{$record->getFirstMedia('work_stage_'.$i)->getUrl('preview')}}">
                                        <img src="{{$record->getFirstMedia('work_stage_'.$i)->getUrl('preview')}}"
                                             class="img-fluid">
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        @endif

        @if($record->getMedia('file')->count() > 0)
            <div class="col-md-12 mb-5">
                <h3>Files</h3>
                @foreach($record->getMedia('file') as $file)
                    <div class="float-left">
                        <a :href="file.url">{{ $file->file_name }}</a>
                    </div>
                    <div class="float-right">
                        {{trans('motor-backend::backend/global.uploaded')}} {{ $file->created_at }}<br>
                    </div>
                    <div class="clearfix"></div>
                @endforeach
            </div>
        @endif

        <div class="col-md-6">
            <h3>{{trans('partymeister-competitions::backend/entries.author_info')}}</h3>
            <dl class="row">
                <dt class="col-sm-4">
                    {{trans('partymeister-competitions::backend/entries.name')}}
                </dt>
                <dd class="col-sm-8">
                    {{ $record->author_name }}
                </dd>

                <dt class="col-sm-4">
                    {{trans('partymeister-competitions::backend/entries.email')}}
                </dt>
                <dd class="col-sm-8">
                    {{ $record->author_email }}
                </dd>

                <dt class="col-sm-4">
                    {{trans('partymeister-competitions::backend/entries.phone')}}
                </dt>
                <dd class="col-sm-8">
                    {{ $record->author_phone }}
                </dd>

                <dt class="col-sm-4">
                    {{trans('partymeister-competitions::backend/entries.address')}}
                </dt>
                <dd class="col-sm-8">
                    {{ $record->author_address }} {{ $record->author_zip }} {{ $record->author_city }} {{
                    $record->author_country }}
                </dd>
            </dl>
        </div>

        @if ($record->competition->competition_type->has_composer)
            <div class="col-md-6">
                <h3>{{trans('partymeister-competitions::backend/entries.composer_info')}}</h3>
                <dl class="row">
                    <dt class="col-sm-4">
                        {{trans('partymeister-competitions::backend/entries.name')}}
                    </dt>
                    <dd class="col-sm-8">
                        {{ $record->composer_name }}
                    </dd>

                    <dt class="col-sm-4">
                        {{trans('partymeister-competitions::backend/entries.email')}}
                    </dt>
                    <dd class="col-sm-8">
                        {{ $record->composer_email }}
                    </dd>

                    <dt class="col-sm-4">
                        {{trans('partymeister-competitions::backend/entries.phone')}}
                    </dt>
                    <dd class="col-sm-8">
                        {{ $record->composer_phone }}
                    </dd>

                    <dt class="col-sm-4">
                        {{trans('partymeister-competitions::backend/entries.address')}}
                    </dt>
                    <dd class="col-sm-8">
                        {{ $record->composer_address }} {{ $record->composer_zip }} {{ $record->composer_city }}
                        {{ $record->composer_country }}
                    </dd>
                </dl>
            </div>
        @endif
    </div>
@endsection