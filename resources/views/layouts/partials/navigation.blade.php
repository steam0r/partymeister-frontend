<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-item" href="#">Revision 2018</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item @if(isset($navHighlight) && $navHighlight == 'home') active @endif">
                        <a class="nav-link" href="{{route('frontend.home')}}">Home</a>
                    </li>
                    <li class="nav-item @if(isset($navHighlight) && $navHighlight == 'visitors') active @endif">
                        <a class="nav-link" href="{{route('frontend.visitors')}}">Who's here</a>
                    </li>
                    <li class="nav-item @if(isset($navHighlight) && $navHighlight == 'timetable') active @endif">
                        <a class="nav-link" href="{{route('frontend.timetable')}}">Timetable</a>
                    </li>
                    <li class="nav-item @if(isset($navHighlight) && $navHighlight == 'items') active @endif">
                        <a class="nav-link" href="{{route('frontend.items')}}">Infodesk</a>
                    </li>
                    <li class="nav-item @if(isset($navHighlight) && $navHighlight == 'vote') active @endif">
                        <a class="nav-link" href="{{route('frontend.votes.index')}}">Vote</a>
                    </li>
                    <li class="nav-item @if(isset($navHighlight) && $navHighlight == 'releases') active @endif">
                        <a class="nav-link" href="{{route('frontend.releases.index')}}">Releases</a>
                    </li>
                    <li class="nav-item @if(isset($navHighlight) && $navHighlight == 'photowall') active @endif">
                        <a class="nav-link" href="{{route('frontend.photowall')}}">Photowall</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
