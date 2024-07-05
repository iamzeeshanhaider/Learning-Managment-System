@extends('layouts.backend.master')
@section('content')
    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/style.css') }}">

    <!--====== Responsive css ======-->
    <link rel="stylesheet" href="{{ asset('jambasangsang/frontend/css/responsive.css') }}">

@section('breadcrumbs')
    <x-bread-crumb pageTitle="Course" previous='Courses' previousLink="{{ route('student.courses') }}"
        current="{{ $course->title }}" />
@endsection

<section id="single-course" class="pt-90 pb-120 gray-bg">
    <div class="container">
        <div class="mb-5">
            <div class="mb-5 corses-tab mt-30">
                <ul class="nav nav-justified" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="{{ $view === 'overview' ? 'active' : '' }}"
                            href="{{ request()->fullUrlWithQuery(['view' => 'overview']) }}">@lang('Overview')</a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ $view === 'lessons' ? 'active' : '' }}"
                            href="{{ request()->fullUrlWithQuery(['view' => 'lessons']) }}">@lang('Lessons')</a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ $view === 'quiz' ? 'active' : '' }}"
                            href="{{ request()->fullUrlWithQuery(['view' => 'quiz']) }}">@lang('Quiz')</a>
                    </li>
                    <li class="nav-item">
                        <a class="{{ $view === 'instructor' ? 'active' : '' }}"
                            href="{{ request()->fullUrlWithQuery(['view' => 'instructor']) }}">@lang('Instructor')</a>
                    </li>
                    @if ($certificate)
                        <li class="nav-item">
                            <a class="{{ $view === 'cert' ? 'active' : '' }}"
                                href="{{ request()->fullUrlWithQuery(['view' => 'cert']) }}">@lang('Certificate')</a>
                        </li>
                    @endif
                </ul>

                <div class="bg-white tab-content" id="myTabContent">
                    @switch($view)
                        @case('overview')
                            @include('jambasangsang.backend.courses.partials.description')
                        @break

                        @case('instructor')
                            @include('jambasangsang.backend.courses.partials.instructor')
                        @break

                        @case('lessons')
                            @include('jambasangsang.backend.courses.partials.curriculum')
                        @break

                        @case('quiz')
                            @include('jambasangsang.backend.courses.partials.quiz')
                        @break

                        @case('cert')
                            @if ($certificate)
                                @include('jambasangsang.backend.certificate.show')
                            @endif
                        @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
