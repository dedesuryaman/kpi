@if ($paginator->hasPages())
<nav>
    <ul class="pagination justify-content-center">

        {{-- FIRST --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url(1) }}">First</a>
        </li>

        {{-- PREVIOUS --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() ?? '#' }}">Prev</a>
        </li>

        {{-- PAGINATION ELEMENTS --}}
        @foreach ($elements as $element)
        {{-- Dots --}}
        @if (is_string($element))
        <li class="page-item disabled">
            <span class="page-link">{{ $element }}</span>
        </li>
        @endif

        {{-- Page Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li>
        @endforeach
        @endif
        @endforeach

        {{-- NEXT --}}
        <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() ?? '#' }}">Next</a>
        </li>

        {{-- LAST --}}
        <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">Last</a>
        </li>

    </ul>
</nav>
@endif