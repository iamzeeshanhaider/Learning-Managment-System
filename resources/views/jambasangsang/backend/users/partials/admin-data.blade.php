<section class="">
    <div class="container">
        <div class="nav-tab mt-30">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="bio-tab" data-toggle="tab" href="#bio" role="tab"
                        aria-controls="bio" aria-selected="true"><span class="h5">@lang('Bio-Data')</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="activity-tab" data-toggle="tab" href="#activity" role="tab"
                        aria-controls="activity" aria-selected="false"><span class="h5">@lang('Activities')</span></a>
                </li>
            </ul>

            <div class="p-5 bg-white tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="bio" role="tabpanel" aria-labelledby="bio-tab">
                    <div class="bio-description">
                        @include('jambasangsang.backend.users.partials.user_bio')
                    </div>
                </div>

                <div class="tab-pane fade show" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                    <div class="activity-description">
                        <livewire:backend.activity-logs-table userID="{{ $user->id }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
