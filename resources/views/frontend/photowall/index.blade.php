@extends('partymeister-frontend::layouts.frontend')

@section('view_styles')
    <style type="text/css">
        .img-thumbnail {
            margin-bottom: 15px;
        }
        .page-link {
            border-radius: 0 !important;
            border: none;
            background-color: #77e15d !important;
        }
    </style>
@endsection


@section('main_content')
    <h1>Photowall 2018</h1>

    <nav style="background: transparent;">
        <ul class="pagination d-flex justify-content-center">
            @if ($currentPage > 1)
            <li class="page-item">
                <a class="page-link" href="{{route('frontend.photowall')}}?page={{$currentPage-1}}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            @endif
            @for ($i=1; $i<=$pages; $i++)
                    <li class="page-item"><a class="page-link @if ($currentPage == $i) active @endif" href="{{route('frontend.photowall')}}?page={{$i}}">{{$i}}</a></li>
            @endfor
            @if ($currentPage < $pages)
            <li class="page-item">
                <a class="page-link" href="{{route('frontend.photowall')}}?page={{$currentPage+1}}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    <div class="row">
        @foreach ($photos as $photo)
            <div class="col-md-4">
                <a href="/photowall/cache/2018/{{$photo}}" data-caption="Revision 2018 Photowall image" data-fancybox="gallery">
                    <img src="/photowall/cache/2018/{{$photo}}" class="img-thumbnail">
                </a>
            </div>
        @endforeach
    </div>
    <nav style="background: transparent;">
        <ul class="pagination d-flex justify-content-center">
            @if ($currentPage > 1)
                <li class="page-item">
                    <a class="page-link" href="{{route('frontend.photowall')}}?page={{$currentPage-1}}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            @endif
            @for ($i=1; $i<=$pages; $i++)
                <li class="page-item"><a class="page-link @if ($currentPage == $i) active @endif" href="{{route('frontend.photowall')}}?page={{$i}}">{{$i}}</a></li>
            @endfor
            @if ($currentPage < $pages)
                <li class="page-item">
                    <a class="page-link" href="{{route('frontend.photowall')}}?page={{$currentPage+1}}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endsection
