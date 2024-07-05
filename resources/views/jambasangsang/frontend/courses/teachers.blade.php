<div class="course-instructor">
    <div class="thum">
        <a href="{{ $course->instructor->link() }}"><img src="{{ $course->instructor->image() }}" alt="instructor"></a>
    </div>
    <div class="name">
        <a href="{{ $course->instructor->link() }}">
            <h6>{{ $course->instructor->name }}</h6>
        </a>
    </div>
    <div class="admin">
        <ul>
            <li><a href="#"><i class="fa fa-user"></i><span>{{ count($course->students) }}</span></a>
            </li>
            <li><a href="#"><i class="fa fa-heart"></i><span>10</span></a></li>
        </ul>
    </div>
</div>
