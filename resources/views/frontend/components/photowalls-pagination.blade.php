<nav aria-label="Pagination">
    <ul class="pagination text-center">
        @if ($currentPage > 1)
            <li class="pagination-previous">
                <a href="{{\Request::url()}}?page={{$currentPage-1}}" aria-label="Previous page">Previous</a>
            </li>
        @else
            <li class="pagination-previous disabled">Previous</li>
        @endif
        @for ($i=1; $i<=$pages; $i++)
            @if ($currentPage == $i)
                <li class="current"><span class="show-for-sr">You're on page</span> {{$i}}</li>
            @else
                <li><a href="{{\Request::url()}}?page={{$i}}" aria-label="Page {{$i}}">{{$i}}</a></li>
            @endif
        @endfor
        @if ($currentPage < $pages)
            <li class="pagination-next"><a href="{{\Request::url()}}?page={{$currentPage+1}}" aria-label="Next page">Next</a></li>
        @else
            <li class="pagination-next disabled">Next</li>
        @endif
    </ul>
</nav>
