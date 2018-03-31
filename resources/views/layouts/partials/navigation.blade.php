<nav class="site-header sticky-top py-1">
    <div class="container d-flex flex-column flex-md-row justify-content-between">
        <a class="py-2" href="{{route('frontend.home')}}">
            REVISION 2018 Party Network
        </a>
        <a class="py-2 d-none d-md-inline-block @if(isset($navHighlight) && $navHighlight == 'home') active @endif" href="{{route('frontend.home')}}">Home</a>
        <a class="py-2 d-none d-md-inline-block @if(isset($navHighlight) && $navHighlight == 'visitors') active @endif" href="{{route('frontend.visitors')}}">Who's here?</a>
        <a class="py-2 d-none d-md-inline-block @if(isset($navHighlight) && $navHighlight == 'timetable') active @endif" href="{{route('frontend.timetable')}}">Timetable</a>
        {{--<a class="py-2 d-none d-md-inline-block @if(isset($navHighlight) && $navHighlight == 'releases') active @endif" href="#">Releases</a>--}}
        <a class="py-2 d-none d-md-inline-block @if(isset($navHighlight) && $navHighlight == 'items') active @endif" href="{{route('frontend.items')}}">Infodesk</a>
    </div>
</nav>