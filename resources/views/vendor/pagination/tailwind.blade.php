@if ($paginator->hasPages())
    <nav class="temple-pagination" role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        {{-- Mobile: Prev / Next only --}}
        <div class="temple-pagination__mobile">
            @if ($paginator->onFirstPage())
                <span class="temple-pagination__btn temple-pagination__btn--disabled">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    {{ __('pagination.previous') }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="temple-pagination__btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    {{ __('pagination.previous') }}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="temple-pagination__btn">
                    {{ __('pagination.next') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            @else
                <span class="temple-pagination__btn temple-pagination__btn--disabled">
                    {{ __('pagination.next') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                </span>
            @endif
        </div>

        {{-- Desktop: Full pagination --}}
        <div class="temple-pagination__desktop">

            {{-- Results info --}}
            <p class="temple-pagination__info">
                Showing
                @if ($paginator->firstItem())
                    <strong>{{ $paginator->firstItem() }}</strong>–<strong>{{ $paginator->lastItem() }}</strong>
                @else
                    <strong>{{ $paginator->count() }}</strong>
                @endif
                of <strong>{{ $paginator->total() }}</strong> results
            </p>

            {{-- Page buttons --}}
            <div class="temple-pagination__pages">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span class="temple-pagination__page-btn temple-pagination__page-btn--nav temple-pagination__page-btn--disabled" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="temple-pagination__page-btn temple-pagination__page-btn--nav" aria-label="{{ __('pagination.previous') }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="temple-pagination__page-btn temple-pagination__page-btn--dots">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="temple-pagination__page-btn temple-pagination__page-btn--active" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="temple-pagination__page-btn" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="temple-pagination__page-btn temple-pagination__page-btn--nav" aria-label="{{ __('pagination.next') }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="temple-pagination__page-btn temple-pagination__page-btn--nav temple-pagination__page-btn--disabled" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif

            </div>
        </div>
    </nav>
@endif
