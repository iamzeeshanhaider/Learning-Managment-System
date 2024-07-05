<div class="tab-pane fade" id="instructor" role="tabpanel"
aria-labelledby="instructor-tab">
    <div class="instructor-cont">
        <div class="instructor-author">
            <div class="author-thum">
                <img src="{{ $course->instructor->image() }}" alt="Instructor">
            </div>
            <div class="author-name">
                <a href="#">
                    <h5>{{ $course->instructor->name }}</h5>
                </a>
                <span>{{ $course->instructor->designation }}</span>
                <ul class="social">
                    <li><a href="mailto:{{ $course->instructor->email }}"><i class="fa fa-envelope"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
