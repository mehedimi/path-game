@if ($paginator->hasPages())
        <nav class="pagination" role="navigation" aria-label="pagination">
            @if($paginator->onFirstPage())
                <a class="pagination-previous">Previous</a>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-previous">Previous</a>
            @endif

            @if($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next">Next</a>
                @else
                    <a class="pagination-next">Next</a>
                @endif

            <ul class="pagination-list">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li><span class="pagination-ellipsis">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><a class="pagination-link is-current" aria-current="page">{{ $page }}</a></li>
                            @else
                                <li><a class="pagination-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </nav>
    @endif
