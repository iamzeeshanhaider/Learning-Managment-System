<section id="course-part" class="pt-115 pb-120 gray-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title pb-45">
                    <h5>@lang('Our course')</h5>
                    <h2>@lang('Featured courses') </h2>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row course-slied mt-30">
            @foreach ($courses as $course)
                <div class="col-lg-4">
                    <div class="single-course">
                        <div class="thum">
                            <div class="image">
                                <img src="{{ $course->image() }}" alt="Course">
                            </div>
                            <div class="price">
                                <span>{{ $course->price() }}</span>
                            </div>
                        </div>
                        <div class="cont">
                            <ul>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <span>(20 Reviws)</span>
                            <a href="{{ $course->link() }}">
                                <h4>{{ $course->name }}</h4>
                            </a>
                            <div class="course-instructor">
                                <div class="thum">
                                    <a href="{{ $course->instructor->singleInstructorLink() }}"><img
                                            src="{{ $course->instructor->image() }}"
                                            alt="{{ $course->instructor->name }}"></a>
                                </div>
                                <div class="name">
                                    <a href="{{ $course->instructor->singleInstructorLink() }}">
                                        <h6>{{ $course->instructor->name }}</h6>
                                    </a>
                                </div>
                                <div class="admin">
                                    <ul>
                                        <li><a href="#"><i
                                                    class="fa fa-user"></i><span>{{ count($course->students) }}</span></a>
                                        </li>
                                        <li><a href="#"><i class="fa fa-heart"></i><span>10</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- single course -->
                </div>
            @endforeach
        </div> <!-- course slied -->
    </div> <!-- container -->
</section>
