<header id="header" class="header">

    <div class="header-menu">

        <div class="col-sm-7">
            <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa-tasks"></i></a>
            <div class="header-left align-items-center d-flex">

                <livewire:backend.notification />
                <livewire:backend.event-notifications />

                {{-- <a class="mx-2" href="{{ route('chat_room') }}"><i class="ti-comments"></i></a> --}}
                <a class="mx-2" href="{{ route('calendar') }}"><i class="ti-calendar"></i></a>

                {{-- <div class="dropdown for-message">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="message"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-email"></i>
                        <span class="count bg-primary">9</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="message">
                        <p class="red">You have 4 Mails</p>
                        <a class="dropdown-item media bg-flat-color-1" href="#">
                            <span class="photo media-left"><img alt="avatar" src="{{ Auth::user()->avatar }}"></span>
                            <span class="message media-body">
                                <span class="float-left name">Jonathan Smith</span>
                                <span class="float-right time">Just now</span>
                                <p>Hello, this is an example msg</p>
                            </span>
                        </a>
                        <a class="dropdown-item media bg-flat-color-4" href="#">
                            <span class="photo media-left"><img alt="avatar" src="{{ Auth::user()->avatar }}"></span>
                            <span class="message media-body">
                                <span class="float-left name">Jack Sanders</span>
                                <span class="float-right time">5 minutes ago</span>
                                <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </span>
                        </a>
                        <a class="dropdown-item media bg-flat-color-5" href="#">
                            <span class="photo media-left"><img alt="avatar" src="{{ Auth::user()->avatar }}"></span>
                            <span class="message media-body">
                                <span class="float-left name">Cheryl Wheeler</span>
                                <span class="float-right time">10 minutes ago</span>
                                <p>Hello, this is an example msg</p>
                            </span>
                        </a>
                        <a class="dropdown-item media bg-flat-color-3" href="#">
                            <span class="photo media-left"><img alt="avatar" src="{{ Auth::user()->avatar }}"></span>
                            <span class="message media-body">
                                <span class="float-left name">Rachel Santos</span>
                                <span class="float-right time">15 minutes ago</span>
                                <p>Lorem ipsum dolor sit amet, consectetur</p>
                            </span>
                        </a>
                    </div>
                </div> --}}

                {{-- <div class="card border-0 mt-1 p-4 rounded"> --}}
                <div class="pl-3"><livewire:backend.select-filter.batches is_user_batch="true" /></div>
                {{-- </div> --}}
            </div>
        </div>

        <div class="col-sm-5">
            <div class="d-flex align-items-center justify-content-end">
                {{-- Attendance Checkin --}}
                @if (!auth()->user()->isStudent())
                    <livewire:backend.mark-attendance>
                @endif

                <div class="language-select dropdown mx-3" id="language-select">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="language" aria-haspopup="true"
                        aria-expanded="true">
                        <i class="flag-icon flag-icon-gb"></i>
                    </a>
                    {{--<div class="dropdown-menu" aria-labelledby="language-select">
                        <div class="dropdown-item">
                            <span class="flag-icon flag-icon-fr"></span>
                        </div>
                        <div class="dropdown-item">
                            <i class="flag-icon flag-icon-es"></i>
                        </div>
                        <div class="dropdown-item">
                            <i class="flag-icon flag-icon-us"></i>
                        </div>
                        <div class="dropdown-item">
                            <i class="flag-icon flag-icon-it"></i>
                        </div>
                    </div>--}}
                </div>

                <div class="user-area dropdown">
                    <a href="#" class="dropdown-toggle d-flex align-items-center text-muted" data-toggle="dropdown" aria-haspopup="true" id="profile"
                        aria-expanded="false">
                        <div class="rounded-circle bg-secondary"
                            style="height: 32px; width: 32px; vertical-align: middle; background-image: url('{{ Auth::user()->avatar }}'); background-position: center;  background-repeat: no-repeat; background-size: cover;">
                        </div>
                        <h6 class="ml-2">{{ auth()->user()->name }}</h6>
                    </a>

                    <div class="user-menu dropdown-menu" aria-labelledby="profile">
                        <a class="nav-link dropdown-item px-2" href="{{ route('user.profile') }}"><i class="fa fa-user"></i>
                            @lang('My Profile')</a>

                        @if (auth()->user()->can('manage_settings'))
                            <a class="nav-link dropdown-item px-2" href="{{ route('settings.index') }}"><i class="fa fa-cog"></i>
                                @lang('Settings')</a>
                        @endif

                        <a class="nav-link dropdown-item px-2" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                            <i class="nav-icon fa fa-power-off red"></i>
                            @lang('Logout')
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>


            </div>



        </div>
    </div>

</header><!-- /header -->
