@if ($paginator->hasPages())
    @php
        $lastPage = $paginator->lastPage();
        $currentPage = $paginator->currentPage();
        if ($lastPage <= 7) {
            $pages = collect(range(1, $lastPage));
        } elseif ($currentPage <= 4) {
            $pages = collect([1, 2, 3, 4, 5, $lastPage]);
        } elseif ($currentPage >= $lastPage - 3) {
            $pages = collect([1, $lastPage - 4, $lastPage - 3, $lastPage - 2, $lastPage - 1, $lastPage]);
        } else {
            $pages = collect([1, $currentPage - 1, $currentPage, $currentPage + 1, $lastPage]);
        }

        $pages = $pages
            ->filter(fn ($page) => $page >= 1 && $page <= $lastPage)
            ->unique()
            ->sort()
            ->values();
        $previousPage = null;
    @endphp

    <nav aria-label="Pagination Navigation">
        <ul class="pagination mb-0">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            @foreach ($pages as $page)
                @if (!is_null($previousPage) && $page - $previousPage > 1)
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">...</span>
                    </li>
                @endif

                @if ($page == $paginator->currentPage())
                    <li class="page-item active" aria-current="page">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endif

                @php
                    $previousPage = $page;
                @endphp
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
