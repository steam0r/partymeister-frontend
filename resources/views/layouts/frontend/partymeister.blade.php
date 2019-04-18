<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{$version->name}} | {{config('motor-backend-project.name_frontend')}}</title>

    <link href="{{ mix('/css/partymeister-frontend.css') }}" rel="stylesheet" type="text/css"/>
    @yield('view-styles')
    <style type="text/css">
        .footer {
            height: 5rem;
            background: #52b9ef;
            color: #fff;
            padding: 1rem;
        }

        .footer .menu a {
            margin-top: 0.25rem;
            color: #333;
        }
        .footer .menu a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
@include('motor-cms::layouts.frontend.partials.navigation')
<div class="grid-container" style="margin-bottom: 8rem;">
    @include('motor-cms::layouts.frontend.partials.template-sections', ['rows' => $template['items']])
</div>
<div class="columns shrink footer text-center" style="position: fixed; bottom: 0; width: 100%;">
    <ul class="menu align-center">
        <li><a href="https://2019.revision-party.net/privacy_policy">Privacy policy</a></li>
    </ul>
</div>
<script src="{{mix('js/partymeister-frontend.js')}}"></script>
@yield('view-scripts')
<script>
    $(document).foundation();
</script>
</body>
</html>