<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu"
                    aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand py-3" href="{{ route('dashboard') }}">
                <img src="{{ Config::get('settings.logo') }}" alt="Logo">
            </a>
            <a class="navbar-brand hidden" href="{{ route('dashboard') }}">
                <img src="{{ Config::get('settings.logo') }}" alt="Logo">
            </a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">

                <li class="{{ is_active('dashboard') }}">
                    <a href="{{ route('dashboard') }}"> <i class="menu-icon fa fa-home"></i>@lang('Dashboard') </a>
                </li>

                {{-- Manage Courses --}}
                <div>
                    @if (auth()->user()->isAdmin() || auth()->user()->hasAnyDirectPermission([
                                'manage_categories',
                                'manage_modules',
                                'manage_locations',
                                'manage_courses_masters',
                                // 'manage_courses',
                                'manage_lessons',
                                'manage_batches',
                            ]))
                        <h3 class="menu-title">@lang('Manage courses')</h3>
                    @endif

                    <div>
                        @can('manage_locations')
                            <li class="{{ is_active('locations.*') }}">
                                <a href="{{ route('locations.index') }}"> <i
                                        class="menu-icon ti-location-arrow"></i>@lang('Locations')
                                </a>
                            </li>
                        @endcan

                        @can('manage_categories')
                            <li class="{{ is_active('categories.*') }}">
                                <a href="{{ route('categories.index') }}"> <i
                                        class="menu-icon ti-layers"></i>@lang('Categories')
                                </a>
                            </li>
                        @endcan

                        {{-- @can('manage_modules')
                            <li class="{{ is_active('modules.*') }}">
                                <a href="{{ route('modules.index') }}"> <i
                                        class="menu-icon ti-layers-alt"></i>@lang('Modules')
                                </a>
                            </li>
                        @endcan --}}

                        @can('manage_courses_masters')
                            <li class="{{ is_active('courses_masters.*') }}">
                                <a href="{{ route('courses_masters.index') }}"> <i
                                        class="menu-icon ti-list"></i>@lang('Courses Master')
                                </a>
                            </li>
                        @endcan

                        @can('manage_courses')
                            <li class="{{ is_active('courses.*') }}">
                                <a href="{{ route('courses.index') }}"> <i
                                        class="menu-icon ti-layout-media-left-alt"></i>@lang('Courses')
                                </a>
                            </li>
                        @endcan

                        @can('manage_lessons')
                            <li class="{{ is_active('lessons.*') }}">
                                <a href="{{ route('lessons.index') }}"> <i
                                        class="menu-icon ti-layout-slider-alt"></i>@lang('Lessons')
                                </a>
                            </li>
                        @endcan

                        @can('manage_batches')
                            <li class="{{ is_active('batches.*') }}">
                                <a href="{{ route('batches.index') }}"> <i
                                        class="menu-icon ti-layout-accordion-separated"></i>@lang('Batches')
                                </a>
                            </li>
                        @endcan
                    </div>
                </div>

                {{-- Manage Users --}}
                <div>
                    @if (auth()->user()->isAdmin() || auth()->user()->hasAnyDirectPermission(['manage_admin', 'manage_students', 'manage_instructors']))
                        <h3 class="menu-title">@lang('Manage Users')</h3>
                    @endif

                    <div>
                        @can('manage_admin')
                            <li class="{{ request()->segment(1) === 'admin' ? 'active' : '' }}">
                                <a href="{{ route('users.index', 'admin') }}"> <i
                                        class="menu-icon fa fa-users"></i>@lang('Admin')
                                </a>
                            </li>
                        @endcan

                        @can('manage_students')
                            <li class="{{ request()->segment(1) === 'student' ? 'active' : '' }}">
                                <a href="{{ route('users.index', 'student') }}"> <i
                                        class="menu-icon fa fa-graduation-cap"></i>@lang('Students') </a>
                            </li>
                        @endcan

                        @can('manage_instructors')
                            <li class="{{ request()->segment(1) === 'instructor' ? 'active' : '' }}">
                                <a href="{{ route('users.index', 'instructor') }}"> <i
                                        class="menu-icon fa fa-users"></i>@lang('Instructors')
                                </a>
                            </li>
                        @endcan
                    </div>
                </div>

                {{-- Manage Activities --}}
                <div>
                    @if(auth()->user()->isAdmin() || auth()->user()->hasAnyDirectPermission([
                                'manage_events',
                                'manage_ticket_categories',
                                'manage_support_tickets',
                                'manage_chat_layers',
                                'manage_chat_requests',
                                'manage_chat',
                            ]))
                        <h3 class="menu-title">@lang('Manage Activities')</h3>
                    @endif

                    <div>
                        @can('manage_events')
                            <li class="{{ is_active('events.*') }}">
                                <a href="{{ route('events.index') }}"> <i
                                        class="menu-icon fa fa-calendar"></i>@lang('Events / News')
                                </a>
                            </li>
                        @endcan

                        @can('manage_ticket_categories')
                            <li class="{{ is_active('ticket_categories.*') }}">
                                <a href="{{ route('ticket_category.index') }}"> <i
                                        class="menu-icon fa fa-bars"></i>@lang('Ticket Categories')
                                </a>
                            </li>
                        @endcan

                        @can('manage_support_tickets')
                            <li class="{{ is_active('tickets.*') }}">
                                <a href="{{ route('tickets.index') }}"> <i
                                        class="menu-icon fa fa-bars"></i>@lang('Support Tickets')
                                </a>
                            </li>
                        @endcan

                        {{-- @can('manage_chat_layers')
                            <li class="{{ is_active('chat_layers.*') }}">
                                <a href="{{ route('chat_layers.index') }}"> <i
                                        class="menu-icon fa fa-bars"></i>@lang('Chat Layers')
                                </a>
                            </li>
                        @endcan

                        @can('manage_chat_requests')
                            <li class="{{ is_active('chat_requests.*') }}">
                                <a href="{{ route('chat_requests.index') }}"> <i
                                        class="menu-icon fa fa-bars"></i>@lang('Chat Requests')
                                </a>
                            </li>
                        @endcan --}}

                      {{--  @can('manage_chat')
                            <li class="{{ is_active('view_chat') }}">
                                <a href="{{ route('live_chat.index') }}"> <i
                                        class="menu-icon fa fa-comments"></i>@lang('Group Broadcasts')
                                </a>
                            </li>
                        @endcan--}}
                    </div>
                </div>

                {{-- Manage Addon --}}
                <div>
                    @if (auth()->user()->isAdmin() || auth()->user()->hasAnyDirectPermission(['view_attendances', 'view_activity_logs']))
                        <h3 class="menu-title">@lang('Addon')</h3>
                    @endif

                    <div>
                        @if (!auth()->user()->isStudent())
                        <li class="{{ is_active('sessions') }}">
                            <a href="{{ route('sessions') }}"> <i class="menu-icon fa fa-video-camera"></i>@lang('Sessions')
                            </a>
                        </li>
                        @endif
                        @can('view_attendances')
                            <li class="{{ is_active('attendance.*') }}">
                                <a href="{{ route('attendance.index') }}">
                                    <i class="menu-icon fa fa-bars">
                                    </i>@lang('Attendance')
                                </a>
                            </li>
                        @endcan
                        @can('view_activity_logs')
                            <li class="{{ is_active('logs.*') }}">
                                <a href="{{ route('logs') }}"> <i class="menu-icon fa fa-bars"></i>@lang('Activity Logs')
                                </a>
                            </li>
                        @endcan
                    </div>
                </div>

                @if (auth()->user()->hasRole('Student'))
                    <li class="{{ is_active('student.courses.*') }}">
                        <a href="{{ route('student.courses') }}"> <i
                                class="menu-icon fa fa-book"></i>@lang('Courses') </a>
                    </li>
                    {{-- <li class="{{ is_active('dashboard') }}">
                        <a href="{{ route('dashboard') }}"> <i class="menu-icon fa fa-envelope"></i>@lang('Messages')
                        </a>
                    </li> --}}
                    <li class="{{ is_active('calendar') }}">
                        <a href="{{ route('calendar') }}"> <i class="menu-icon fa fa-calendar"></i>@lang('Calendar')
                        </a>
                    </li>
                    <li class="{{ is_active('sessions') }}">
                        <a href="{{ route('sessions') }}"> <i class="menu-icon fa fa-video-camera"></i>@lang('Sessions')
                        </a>
                    </li>
                    <li class="{{ is_active('tickets.*') }}">
                        <a href="{{ route('tickets.index') }}"> <i class="menu-icon fa fa-ticket"></i>@lang('Support')
                        </a>
                    </li>
                    {{--<li class="{{ is_active('dashboard') }}">
                        <a href="{{ route('live_chat.index') }}"> <i
                                class="menu-icon fa fa-comments"></i>@lang('Broadcasts Chat')
                        </a>
                    </li>--}}

                @endif
            </ul>

        </div><!-- /.navbar-collapse -->
    </nav>
</aside><!-- /#left-panel -->
