<!--====== Style css ======-->
<link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/style.css') }}">

<!--====== Responsive css ======-->
<link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/responsive.css') }}">

@props([
    'view' => 'list',
    'has_header' => true,
    'has_paginator' => true,
    'has_list' => true,
    'has_grid' => true,
])
<section id="courses-part" class="pt-120 pb-120 gray-bg">
    <div class="container">
        @if ($has_header)
            <div class="row">
                <div class="col-lg-12">
                    <div class="courses-top-search d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <ul class="nav" id="myTab" role="tablist">
                                @if ($has_grid)
                                    <li class="nav-item">
                                        <a class="{{ $view === 'grid' ? 'active' : '' }}"
                                            href="{{ request()->fullUrlWithQuery(['view' => 'grid']) }}"><i
                                                class="fa fa-th-large"></i></a>
                                    </li>
                                @endif
                                @if ($has_list)
                                    <li class="nav-item">
                                        <a class="{{ $view === 'list' ? 'active' : '' }}"
                                            href="{{ request()->fullUrlWithQuery(['view' => 'list']) }}"><i
                                                class="fa fa-th-list"></i></a>
                                    </li>
                                @endif
                                <li class="nav-item">Showing {{ $stats }} Results</li>
                            </ul> <!-- nav -->
                            @if ($filter)
                                <div class="px-2"> {{ $filter }}</div>
                            @endif
                        </div>

                        <div class="" data-search="search">
                            <form class="courses-search">
                                <input name="search" value="{{ request('search') }}" type="text"
                                    class="form-control" placeholder="Press enter after typing">
                                @if (request('search') != null)
                                    <button type="button">
                                        <a href="{{ request()->fullUrlWithQuery(['search' => '']) }}" class=""
                                            data-target="search">
                                            <i class="fa fa-times text-danger"></i>
                                        </a>
                                    </button>
                                @else
                                    <button type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($header)
            {{ $header }}
        @endif

        <!-- tab content -->
        {{ $content }}
        <!-- tab content -->

        <!-- tab content -->
        @if ($has_paginator)
            <div class="py-4">
                {{ $paginator }}
            </div>
        @endif
        <!-- tab content -->
    </div> <!-- container -->
</section>
