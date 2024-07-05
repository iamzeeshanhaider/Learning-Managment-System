<section id="instructors-part" class="pt-70 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="section-title mt-50">
                    <h5>@lang('Featured Instructors')</h5>
                    <h2>@lang('Meet Our Instructors')</h2>
                </div> <!-- section title -->
                <div class="instructors-cont">
                    <p>{!! Config::get('settings.about_instructors') !!}</p>
                    <a href="#" class="main-btn mt-55">@lang('Career with us')</a>
                </div> <!-- instructors cont -->
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="instructors mt-20">
                    <div class="row">
                        @foreach ($instructors as $instructor)
                            <div class="col-sm-6">
                                <div class="single-instructors mt-30 text-center">
                                    <div class="image">
                                        <img src="{{ $instructor->image() }}" alt="{{ $instructor->name }}">
                                    </div>
                                    <div class="cont">
                                        <a href="{{ $instructor->singleInstructorLink() }}">
                                            <h6>{{ $instructor->name }}</h6>
                                        </a>
                                        <span>{{ $instructor->designation }}</span>
                                    </div>
                                </div> <!-- single instructorS -->
                            </div>
                        @endforeach
                    </div> <!-- row -->
                </div> <!-- instructorS -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>
