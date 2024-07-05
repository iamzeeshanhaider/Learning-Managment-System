@if ($paginator->hasPages())
<div class="row">
    <div class="col-lg-12">
        <nav class="courses-pagination mt-50">
            <ul class="pagination justify-content-center">

                {{-- Previous Page Link --}}
                <li class="page-item" aria-label="@lang('pagination.previous')">
                    @if ($paginator->onFirstPage())
                    <a href="javascript:void(0)" disabled class="disabled">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    @else
                    <a href="{{ $paginator->previousPageUrl() }}">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    @endif
                </li>

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled page-item" aria-disabled="true"><a href="javascript:void(0)">{{ $element }}</a></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item" aria-current="page">
                                    <a class="active" href="javascript:void(0)">{{ $page }}</a>
                                </li>
                            @else
                                <li class="page-item"><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                <li class="page-item" aria-label="@lang('pagination.next')">
                    @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                    @else
                    <a href="javascript:void(0)" disabled class="disabled">
                        <i class="fa fa-angle-right"></i>
                    </a>
                    @endif
                </li>
            </ul>
        </nav>
    </div>
</div>
@endif
