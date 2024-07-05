@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb pageTitle="Courses" previous='' previousLink="" current="Courses" />
@endsection

<x-grid-listing view="{{ $view }}">

    <x-slot:stats>
        @if (isset($courses))
            {{ $courses->count() }} of {{ $courses->total() }}
        @else
            0 of 0
        @endif
    </x-slot:stats>

    <x-slot:filter>
        <a href="{{ request()->fullUrlWithQuery(['order_dir' => 'desc']) }}"
            class="{{ request('order_dir', 'desc') === 'desc' ? 'd-none' : 'd-block text-success' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-sort-up" viewBox="0 0 16 16">
                <path
                    d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.498.498 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707V12.5zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
            </svg>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['order_dir' => 'asc']) }}"
            class="{{ request('order_dir') === 'asc' ? 'd-none' : 'd-block text-success' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-sort-down" viewBox="0 0 16 16">
                <path
                    d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
            </svg>
        </a>
    </x-slot:filter>

    <x-slot:header>
    </x-slot:header>

    <x-slot:content>
        <div class="tab-content py-3" id="">
            <div class="tab-pane fade show active" id="courses-grid" role="tabpanel"
                aria-labelledby="courses-grid-tab">
                <div class="row">
                    @if (isset($courses) && count($courses))
                        @foreach ($courses as $index => $course)
                            @switch($view)
                                @case('list')
                                    <x-course.list :course="$course" :id="$index" />
                                @break

                                @default
                                    <x-course.grid :course="$course" :id="$index" />
                            @endswitch
                        @endforeach
                    @else
                        <div class="p-5 m-auto h-100 w-100 text-center">
                            <div class="card p-5">
                                <div class="card-title">
                                    @if (request('search'))
                                        <h5>No Results Found</h5>
                                        <a href="{{ request()->fullUrlWithQuery(['search' => '']) }}"
                                            class="btn-link btn btn-sm" data-target="search">
                                            Clear Search
                                        </a>
                                    @else
                                        <h5>You are not enrolled for any course yet</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div> <!-- row -->
            </div>
        </div>
    </x-slot:content>

    <x-slot:paginator>
        {{ isset($courses) ? $courses->links('vendor.pagination.iro-custom') : '' }}
    </x-slot:paginator>

</x-grid-listing>

@endsection
