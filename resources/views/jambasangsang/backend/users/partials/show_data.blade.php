<section class="">
    <div class="container ">
        <div class="nav-tab mt-30">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $view === 'bio' ? 'active' : '' }}" id="bio-tab"
                        href="{{ request()->fullUrlWithQuery(['v' => 'bio']) }}" role="tab" aria-controls="bio"
                        aria-selected="true"><span class="h6">@lang('Bio-Data')</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $view === 'activity' ? 'active' : '' }}" id="activity-tab"
                        href="{{ request()->fullUrlWithQuery(['v' => 'activity']) }}" role="tab"
                        aria-controls="activity" aria-selected="false"><span class="h6">@lang('Activities')</span></a>
                </li>

                @switch($group)
                    @case('admin')
                        {{-- @include('jambasangsang.backend.users.partials.admin-data') --}}
                    @break

                    @case('instructor')
                        {{-- @include('jambasangsang.backend.users.partials.instructor-data') --}}
                    @break

                    @case('student')
                        <li class="nav-item">
                            <a class="nav-link {{ $view === 'record' ? 'active' : '' }}" id="student-tab"
                                href="{{ request()->fullUrlWithQuery(['v' => 'record']) }}" role="tab"
                                aria-controls="student" aria-selected="false">
                                <span class="h6">@lang('Student Record')</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $view === 'payments' ? 'active' : '' }}" id="payments-tab"
                                href="{{ request()->fullUrlWithQuery(['v' => 'payments']) }}" role="tab"
                                aria-controls="payments" aria-selected="false">
                                <span class="h6">@lang('Payments')</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $view === 'meeting' ? 'active' : '' }}" id="meeting-tab"
                                href="{{ request()->fullUrlWithQuery(['v' => 'meeting']) }}" role="tab"
                                aria-controls="meeting" aria-selected="false">
                                <span class="h6">@lang('Meetings')</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="progress-tab" data-toggle="tab" href="#progress" role="tab"
                                aria-controls="progress" aria-selected="false"><span class="h5">@lang('Student Progress')</span></a>
                        </li> --}}
                    @break
                @endswitch
            </ul>

            <div class="p-5 bg-white tab-content" id="myTabContent">

                <div class="tab-pane fade show {{ $view === 'bio' ? 'active' : '' }}" id="bio" role="tabpanel"
                    aria-labelledby="bio-tab">
                    <div class="bio-description">
                        @include('jambasangsang.backend.users.partials.user_bio')
                    </div>
                </div>

                <div class="tab-pane fade show {{ $view === 'activity' ? 'active' : '' }}" id="activity"
                    role="tabpanel" aria-labelledby="activity-tab">
                    <div class="activity-description">
                        <livewire:backend.activity-logs-table userID="{{ $user->id }}" />
                    </div>
                </div>
                @switch($group)
                    @case('admin')
                        {{-- @include('jambasangsang.backend.users.partials.admin-data') --}}
                    @break

                    @case('instructor')
                        {{-- @include('jambasangsang.backend.users.partials.instructor-data') --}}
                    @break

                    @case('student')
                        <div class="tab-pane fade show {{ $view === 'record' ? 'active' : '' }}" id="record" role="tabpanel"
                            aria-labelledby="record-tab">
                            <div class="record-description">
                                @include('jambasangsang.backend.users.partials.student.student-record')
                            </div>
                        </div>
                        <div class="tab-pane fade show {{ $view === 'payments' ? 'active' : '' }}" id="payments"
                            role="tabpanel" aria-labelledby="payments-tab">
                            <div class="payments-description">
                                @include('jambasangsang.backend.users.partials.student.payments-log')
                            </div>
                        </div>
                        <div class="tab-pane fade show {{ $view === 'meeting' ? 'active' : '' }}" id="meeting"
                            role="tabpanel" aria-labelledby="meeting-tab">
                            <div class="meeting-description">
                                <livewire:backend.google.event student="{{ $user->id }}" />
                            </div>
                        </div>
                    @break
                @endswitch

            </div>
        </div>
    </div>
</section>
