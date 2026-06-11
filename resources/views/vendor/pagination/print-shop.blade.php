@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center justify-between gap-3 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] px-4 text-sm font-semibold text-[#33302d]/35">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/15 bg-white px-4 text-sm font-semibold text-[#33302d] transition hover:border-[#d9782a]/40 hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/15 bg-white px-4 text-sm font-semibold text-[#33302d] transition hover:border-[#d9782a]/40 hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#d9782a] focus-visible:ring-offset-2">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="inline-flex h-11 items-center justify-center rounded-sm border border-[#33302d]/10 bg-[#f7f7f5] px-4 text-sm font-semibold text-[#33302d]/35">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:w-full sm:items-center sm:justify-center">
            <span class="inline-flex overflow-hidden rounded-sm border border-[#33302d]/12 bg-white">
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="inline-flex h-11 w-11 items-center justify-center border-r border-[#33302d]/10 text-[#33302d]/30">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}" class="inline-flex h-11 w-11 items-center justify-center border-r border-[#33302d]/10 text-[#33302d]/65 transition hover:bg-[#fff8ef] hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#d9782a]">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span aria-disabled="true" class="inline-flex h-11 min-w-11 items-center justify-center border-r border-[#33302d]/10 px-4 text-sm font-semibold text-[#33302d]/45">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="inline-flex h-11 min-w-11 items-center justify-center border-r border-[#d9782a]/25 bg-[#fff8ef] px-4 text-sm font-semibold text-[#d9782a]">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}" class="inline-flex h-11 min-w-11 items-center justify-center border-r border-[#33302d]/10 px-4 text-sm font-semibold text-[#33302d]/65 transition hover:bg-[#fff8ef] hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#d9782a]">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}" class="inline-flex h-11 w-11 items-center justify-center text-[#33302d]/65 transition hover:bg-[#fff8ef] hover:text-[#d9782a] focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#d9782a]">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" class="inline-flex h-11 w-11 items-center justify-center text-[#33302d]/30">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </span>
        </div>
    </nav>
@endif
