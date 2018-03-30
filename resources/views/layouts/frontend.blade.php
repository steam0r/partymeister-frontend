<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Revision 2018</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/css/frontend.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/revision2018.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Custom styles for this template -->
    @yield('view_styles')
    <style type="text/css">
        main {
            margin-top: 80px;
        }
    </style>
</head>

<body>

@include('partymeister-frontend::layouts.partials.navigation')

<main role="main" class="container">
    <div class="row">
        <div class="col-md-9">
            @yield('main_content')
        </div>
        <div class="col-md-3">
            @include('partymeister-frontend::frontend.login.form')
            @yield('sidebar')
        </div>
    </div>
</main><!-- /.container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
@include('partymeister-frontend::layouts.partials.view_scripts')
@yield('view_scripts')
</body>
</html>
