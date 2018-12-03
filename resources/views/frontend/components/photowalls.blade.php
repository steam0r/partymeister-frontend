@section('view-styles')
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


<h4>Photowall</h4>

@include('partymeister-frontend::frontend.components.photowalls-pagination')
<div class="grid-x grid-margin-x">
    @foreach ($photos as $photo)
        <div class="cell medium-4 small-12">
            <a href="/photowall/cache/{{$photo}}" data-caption="Photowall image" data-fancybox="gallery">
                <img src="/photowall/cache/{{$photo}}" alt="Photo" class="thumbnail">
            </a>
        </div>
    @endforeach
</div>
@include('partymeister-frontend::frontend.components.photowalls-pagination')
