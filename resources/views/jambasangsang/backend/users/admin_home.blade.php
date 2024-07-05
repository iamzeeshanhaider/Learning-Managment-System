@section('css')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css">
    <style>
        .stat-text a {
            word-wrap: break-word !important;
        }
    </style>
@endsection

@can('view_students')
    <div class="col-sm-6 col-lg-3">
        <div class="text-white card bg-flat-color-1">
            <a class="pb-0 card-body d-block text-white" href="{{ route('users.index', 'student') }}">

                <h4 class="mb-0">
                    <span>{!! $totalSales !!}</span>
                </h4>
                <p class="text-light">Amount Paid</p>

                <div class="px-0 chart-wrapper" style="height:70px;" height="70">
                    <i class="fa fa-pound-sign fa-4x"></i>
                </div>

            </a>
        </div>
    </div>
@endcan

@can('view_students')
    <div class="col-sm-6 col-lg-3">
        <div class="text-white card bg-flat-color-1">
            <a class="pb-0 card-body d-block text-white" href="{{ route('users.index', 'student') }}">

                <h4 class="mb-0">
                    <span>{!! formatCount($numberOfStudents) !!}</span>
                </h4>
                <p class="text-light">@lang('roles.student')</p>

                <div class="px-0 chart-wrapper" style="height:70px;" height="70">
                    <i class="fa fa-graduation-cap fa-4x"></i>
                </div>

            </a>
        </div>
    </div>
@endcan {{-- Total Number of Students --}}

<!--/.col-->
@can('view_instructors')
    <div class="col-sm-6 col-lg-3">
        <div class="text-white card bg-flat-color-2">
            <a class="pb-0 card-body d-block text-white" href="{{ route('users.index', 'instructor') }}">
                <h4 class="mb-0">
                    <span>{!! formatCount($numberOfInstructors) !!}</span>
                </h4>
                <p class="text-light">@lang('roles.instructor')</p>

                <div class="px-0 chart-wrapper" style="height:70px;" height="70">
                    <i class="fas fa-chalkboard-teacher fa-4x"></i>
                </div>

            </a>
        </div>
    </div>
@endcan {{-- Total Number of Instructors --}}
<!--/.col-->

@can('view_admin')
    <div class="col-sm-6 col-lg-3">
        <div class="text-white card bg-flat-color-3">
            <a class="pb-0 card-body d-block text-white" href="{{ route('users.index', 'admin') }}">
                <h4 class="mb-0">
                    <span>{!! formatCount($numberOfAdmins) !!}</span>
                </h4>
                <p class="text-light">@lang('roles.admin')</p>
                <div class="px-3 chart-wrapper" style="height:70px;" height="70">
                    <i class="fa fa-user fa-4x"></i>
                </div>
            </a>
        </div>
    </div>
@endcan {{-- Total Number of Admins --}}
<!--/.col-->

@php
    $socials = ['facebook', 'twitter', 'instagram', 'linkedin', 'google-plus'];
@endphp

<div class="col-lg-3 col-md-6">
    <a class="social-box d-block text-white {{ $socials[array_rand($socials)] }}" href="{{ route('courses.index') }}">
        <i class="fa fa-book fa-4x"></i>
        <ul>
            <li>
                <span class="">{!! formatCount(count($numberOfCoursesAndStudents)) !!}</span>
                <span>@lang('Courses')</span>
            </li>
            <li>
                <span class="">{!! formatCount($numberOfInactiveCourses) !!}</span>
                <span style=" color:red">@lang('Inactive')</span>
            </li>
        </ul>
    </a>
    <!--/social-box-->
</div> {{-- Total Number of Courses and Inactive Courses --}}
<!--/.col-->

<div class="col-lg-3 col-md-6">
    <div class="social-box {{ $socials[array_rand($socials)] }}">
        <i class="fa fa-graduation-cap fa-4x"></i>
        <ul>
            <li>
                <small class="">{!! formatCount($numberOfActiveStudents) !!}</small>
                <small style="color:green">@lang('Active') Students</small>
            </li>
            <li>
                <small class="">{!! formatCount($numberOfInactiveStudents) !!}</small>
                <small style=" color:red">@lang('Inactive') Students</small>
            </li>
        </ul>
    </div>
    <!--/social-box-->
</div> {{-- Total Number of Active & Inactive students --}}
<!--/.col-->


<div class="col-sm-6 col-lg-3">
    <div class="social-box {{ $socials[array_rand($socials)] }}">
        <i class="fa fa-male"></i>
        <div>
            <span class="">{!! formatCount($numberOfMaleStudents) !!}</span>
            <span style="color:green">@lang('Male')</span>
            <p>Gender</p>
        </div>
    </div>
</div>

<div class="col-sm-6 col-lg-3">
    <div class="social-box {{ $socials[array_rand($socials)] }}">
        <i class="fa fa-female"></i>
        <div>
            <span class="">{!! formatCount($numberOfFemaleStudents) !!}</span>
            <span style="color:green">@lang('Female')</span>
            <p>Gender</p>
        </div>
    </div>
</div>

<div class="col-sm-6 col-lg-3">
    <div class="social-box {{ $socials[array_rand($socials)] }}">
        <i class="fa fa-genderless"></i>
        <div>
            <span class="">{!! formatCount($numberOfOtherGenderStudents) !!}</span>
            <span style=" color:red">@lang('Others')</span>
            <p>Gender</p>
        </div>
    </div>
</div>
<!--/.col-->

@can('view_students')
@foreach ($batches as $batch)
<div class="col-sm-6 col-lg-4">
    <div class="text-white card bg-flat-color-{{ array_rand(['1', '2', '3', '4', '5'], 1) + 1 }}">
        <a class="pb-0 card-body d-block text-white" href="{{ route('batches.index') }}">

            <h4 class="mb-0">
                <span>{!! formatCount($batch->students_count) !!}</span>
            </h4>
            <p class="text-light">Batch: {{ str_limit($batch->name, 50) }}</p>

            <div class="px-0 chart-wrapper" style="height:70px;" height="70">
                <i class="fas fa-object-group fa-4x"></i>
            </div>

        </a>
    </div>
</div>
@endforeach
@endcan {{-- Total Number of Students Grouped by Batches--}}


<!--/.col-->
{{-- @foreach ($numberOfCoursesAndStudents as $studentCourse)
    <div class="col-xl-4 col-lg-6">
        <div class="card">
            <div class="card-body">
                <a onclick="handleGeneralModal(this)" data-link="{{ route('courses.show', ['course' => $studentCourse->slug]) }}">
                    <div class="stat-widget-one d-flex">
                        <div class="stat-icon dib"><img src="{{ $studentCourse->image() }}" alt="" height="60"></div>
                        <div class="stat-content dib">
                            <div class="stat-text" title="{{ $studentCourse->title }}">{{ str_limit($studentCourse->title, 30) }}</div>
                            <div class="stat-digit">
                                <i class="ti-user text-success border-success"></i>
                                {!! formatCount($studentCourse->students_count) !!}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endforeach --}}
