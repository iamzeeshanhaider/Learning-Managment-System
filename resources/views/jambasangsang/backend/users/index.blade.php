@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb pageTitle='{{ ucwords($group) }} List' previous="" previousLink="" current="Users" />
@endsection

<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header border-bottom bg-light">
                    <div class="d-flex justify-content-between align-start">
                        <strong class="card-title">
                            {{ ucwords($group) }}'s @lang('List')
                        </strong>
                        @if ($group === 'student')
                            <div class="border-left p-2">
                                <div class="custom-drop-select dropup" id="course-select">
                                    <a class="dropdown-toggle text-black" href="#" data-toggle="dropdown"
                                        id="course" aria-haspopup="true" aria-expanded="false">
                                        <small>
                                            <b>Filter by Course:</b>
                                            <br class="p-0 m-0">
                                            {{ str_limit($course->title ?? 'Click to Select Course', 50) }}
                                        </small>
                                        <i data-toggle="tooltip" title="Click to switch course"
                                            class="fa fa-exclamation-circle text-success"></i>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="course">
                                        <livewire:backend.select-filter.courses :selected="$course !== 'all' ? $course->slug : $course" />
                                    </div>
                                </div>
                            </div>

                            <div class="border-left p-2">
                                <a href="{{ $filterByBatch ? request()->fullUrlWithoutQuery('batch_filter') : request()->fullUrlWithQuery(['batch_filter' => 'true'])}}" class="small">
                                    <b>{{ $filterByBatch ? 'Clear' : '' }} Filter by Batch</b>
                                </a>
                            </div>
                        @endif
                        <div class="border-left p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                @if (isset($course->id) || $filterByBatch)
                                    <a href="{{ route('users.index', ['group' => $group]) }}"
                                        class="mx-1 btn btn-sm btn-primary">
                                        <small><i class="fa fa-filter"></i> Clear Filter</small>
                                    </a>
                                @endif

                                @if (isset($course->id))
                                    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary"
                                        title="Enroll Students"
                                        data-link="{{ route('students.bulk_enrol.init', ['course' => $course->slug]) }}">
                                        <small><i class="fa fa-user-plus"></i> Enrol Student</small>
                                    </a>
                                @endif


                                @if (auth()->user()->isAdmin() || auth()->user()->can('manage_students'))
                                    <a onclick="handleGeneralModal(this)"
                                        data-link="{{ route('users.create', ['group' => $group]) }}" type="button"
                                        class="mx-1 text-white btn btn-sm btn-success"><small>@lang('New User')</small></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:backend.user-table group="{{ $group }}" :course="$course !== 'all' ? $course->id : $course" :filterByBatch="$filterByBatch" />
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
