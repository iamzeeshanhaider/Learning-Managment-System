<div class="instructor-cont">
    <div class="instructor-author">
        <div class="author-thum">
            <div class="rounded-circle bg-secondary"
                style="height: 60px; width: 60px; vertical-align: middle; background-image: url('{{ $course->instructor->avatar }}'); background-position: center;  background-repeat: no-repeat; background-size: cover;">
            </div>
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
