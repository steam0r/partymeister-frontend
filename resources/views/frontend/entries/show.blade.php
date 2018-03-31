@extends('partymeister-frontend::layouts.frontend')
@section('view_styles')
    @include('partymeister-slides::layouts.partials.slide_fonts')
    <style type="text/css">
        .slidemeister-instance {
            zoom: 0.75;
            float: left;
            margin-right: 15px;
            margin-bottom: 15px;
        }

        .slidemeister-element.active {
            border: 2px solid red;
        }

        .slidemeister-canvas-bounds,
        .slidemeister-canvas-bounds-n,
        .slidemeister-canvas-bounds-e,
        .slidemeister-canvas-bounds-s,
        .slidemeister-canvas-bounds-w {
            opacity: 0.5;
            background-color: #ddd;
            position: absolute;
            z-index: 500000;
        }

        .slidemeister-canvas-bounds-n {
            top: 0;
            width: 1152px;
            height: 54px;
        }

        .slidemeister-canvas-bounds-s {
            top: 595px;
            width: 1152px;
            height: 54px;
        }

        .slidemeister-canvas-bounds-e {
            top: 54px;
            left: 1056px;
            width: 96px;
            height: 541px;
        }

        .slidemeister-canvas-bounds-w {
            top: 54px;
            left: 0px;
            width: 96px;
            height: 541px;
        }

        #slidemeister-wrapper {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        #slidemeister-canvas {
            width: 100%;
            height: 75vh;
            /*width: 1152px;*/
            /*height: 648px;*/
            border: 1px solid #c2cfd6;
            border-top: none;
            /*border: 1px solid black;*/
            /*background-color: #cacaca;*/

            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;

            background-color: #abcdef;
            background-size: 100px 100px, 100px 100px, 20px 20px, 20px 20px;
            background-position: -2px -2px, -2px -2px, -1px -1px, -1px -1px;
            background-image: -webkit-linear-gradient(white 2px, transparent 2px),
            -webkit-linear-gradient(0, white 2px, transparent 2px),
            -webkit-linear-gradient(rgba(255, 255, 255, .1) 1px, transparent 1px),
            -webkit-linear-gradient(0, rgba(255, 255, 255, .1) 1px, transparent 1px);
            background-image: -moz-linear-gradient(white 2px, transparent 2px),
            -moz-linear-gradient(0, white 2px, transparent 2px),
            -moz-linear-gradient(rgba(255, 255, 255, .1) 1px, transparent 1px),
            -moz-linear-gradient(0, rgba(255, 255, 255, .1) 1px, transparent 1px);
            background-image: linear-gradient(white 2px, transparent 2px),
            linear-gradient(90deg, white 2px, transparent 2px),
            linear-gradient(rgba(255, 255, 255, .1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, .1) 1px, transparent 1px);
            -pie-background: linear-gradient(white 2px, transparent 2px) -2px -2px / 100px,
            linear-gradient(90deg, white 2px, transparent 2px) -2px -2px / 100px,
            linear-gradient(rgba(255, 255, 255, .1) 1px, transparent 1px) -1px -1px / 20px,
            linear-gradient(90deg, rgba(255, 255, 255, .1) 1px, transparent 1px) -1px -1px / 20px,
            #269;
        }

        #slidemeister-canvas-border {
            border: 1px solid black;
            position: absolute;
            width: 960px;
            height: 540px;
            /*z-index: 30000;*/
        }

        #slidemeister, #vuedropzone, .slidemeister-instance {
            clip-path: inset(0);
            background-color: #fff;
            border: 1px solid black;
            position: relative;
            /*margin: 0 auto;*/
            /*float: left;*/
            /*width: 1920px;*/
            /*height: 1080px;*/
            width: 960px;
            height: 540px;
            /*display: none;*/

            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        #vuedropzone {
            position: absolute;
            background: transparent;
        }
        .draggable-container {
            width: 100%;
            height: 100%;
        }

        .slidemeister-element {
            position: absolute;
            width: 200px;
            height: 100px;
            left: 50px;
            top: 50px;
            background-color: transparent;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            border: 2px solid transparent;
            /*border-top: 1px solid #999;*/
            /*border-left: 1px solid #999;*/
            /*border-bottom: 1px solid #ccc;*/
            /*border-right: 1px solid #ccc;*/
            padding: 0;
            margin: 0;
            /*overflow: hidden;*/
        }

        #slidemeister-properties {
            /*float: left;*/
            /*margin-left: 5px;*/
        }

        .form-control-sm {
            display: inline-block;
            max-width: 100px;
            float: right;
        }

        .slidemeister-property-list {
            justify-content: space-between;
        }

        .minicolors-theme-default .minicolors-input {
            height: auto !important;
            padding-left: 0.5rem !important;
        }

        .minicolors-swatch {
            z-index: 1000;
        }

        p.draghandle {
            display: none;
            z-index: 11000;
            cursor: move;
            font-size: 12px;
            position: absolute;
            left: -5px;
            top: -5px;
            color: #000000;
            text-shadow: none !important;

            border: 3px solid #666666;
            border-radius: 50px;
            background-color: white;
            padding: 4px;
        }

        .ui-resizable-handle.ui-resizable-se {
            z-index: 11000;
            cursor: move;
            font-size: 12px;
            position: absolute;
            right: -5px;
            bottom: -5px;
            color: #000000;
            text-shadow: none !important;

            border: 3px solid #666666;
            border-radius: 50px;
            background-color: white;
            padding: 4px;
        }

        .editable {
            background: transparent;
        }

        .slidemeister-element span.edit {
            width: 100%;
            height: 100%;
            display: inline-block;
        }

        .dragging {
            z-index: 90000;
        }

        .slidemeister-element-mouseover {
            opacity: 0.2 !important;
            /*background-color: #000;*/
        }

        .slidemeister-element-mouseover-highlight {
            border: 2px solid red;
        }

        .slidemeister-element-mouseover-elementlist-highlight {
            border: 2px dotted red;
            /*opacity: 0.9 !important;*/
            /*background-color: #fff;*/
        }

        .editable:focus {
            outline: none;
            padding: 0;
            margin: 0;
        }

        .editable {
            border: none;
        }

        .ui-rotatable-handle {
            /*height: 16px;*/
            /*width: 16px;*/
            /*cursor: pointer;*/
            /*background-image: url(../images/rotate.png);*/
            /*background-size: 100%;*/
            /*left: 2px;*/
            /*bottom: 2px;*/

            z-index: 11000;
            cursor: move;
            font-size: 12px;
            position: absolute;
            left: auto;
            right: -5px;
            top: -5px;
            color: #000000;
            text-shadow: none !important;

            border: 3px solid #666666;
            border-radius: 50px;
            background-color: white;
            padding: 4px;
        }

        #slidemeister-layers-container .list-group-item {
            padding: 0.25rem 0.5rem;
        }

        .slidemeister-navbar .nav-item {
            width: 50%;
            text-align: center;
        }
        .slidemeister-element div span p {
            margin-bottom: 0 !important;
        }
        .slidemeister-element {
            display: flex;
        }
        [contenteditable]:focus {
            outline: 0px solid transparent;
        }

        body#slidemeister-render #slidemeister {
            border: none !important;
            zoom: 2;
            background-color: transparent;
            position: relative;
        }

        body#slidemeister-render .slidemeister-element {
            position: absolute;
            width: 200px;
            height: 100px;
            left: 50px;
            top: 50px;
            background-color: transparent;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            border: 2px solid transparent;
            padding: 0;
            margin: 0;
        }
    </style>
@append
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
            <h3>Beamslide preview</h3>
            <div id="slidemeister-competition-preview" class="slidemeister-instance"></div>
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

@section('view_scripts')
    @include('partymeister-slides::layouts.partials.slide_scripts')
    <script>
        $(document).ready(function () {
            var sm = $('#slidemeister-competition-preview').slidemeister('#slidemeister-properties', slidemeisterProperties);
            sm.data.load({!! $competitionTemplate->definitions !!}, {!! json_encode($entry) !!}, false, true);
        });
    </script>
@append
