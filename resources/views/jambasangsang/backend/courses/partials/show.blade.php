<div class="card">
    <div class="card-body">
        <div class="col-6">
            <h5 class="mt-3 card-title">Image:</h5>
            <img src="{{ $course->image() }}" alt="" width="200px" height="200px" style="object-fit: contain">

            <h5 class="mt-3 card-title">Title:</h5>
            <span class="card-title">{{ $course->title }}</span>

            <h5 class="mt-3 card-title">Module:</h5>
            <span class="card-title">{{ $course->module->name }}</span>

        </div>

        <div class="weather-category twt-category col-6">
            <div>
                <h5 class="mt-3 card-title">Location:</h5>
                <span class="card-title">{{ $course->location->name }}</span>

                <h5 class="mt-3 card-title">Instructor:</h5>
                <div class="instructor-name d-flex align-item-center mb-3">
                    <div class="thum">
                        <img src="{{ $course->instructor->image() }}" alt="{{ $course->instructor->name }}" width="50"
                            height="50">
                    </div>
                    <div class="pl-2 name">
                        <span class="card-title">{{ $course->instructor->name }}</span>
                        <br>
                        <small>{{ $course->instructor->designation ?? '' }}</small>
                    </div>
                </div>
            </div>
            <hr>
            <ul>
                <li class="active">
                    <a href="#" title="Status">
                        <span class="h6 text-{{ $course->status_color() }}">{{ $course->status }}</span>
                        <br>
                        Status
                    </a>
                </li>
                <li>
                    <a href="#" title="Linked Participants">
                        <span class="h5">{{ $course->students->count() }}</span>
                        <br>
                        Participants
                    </a>
                </li>
                <li>
                    <a href="#" title="Course Price">
                        <span class="h5">{{ $course->price() }}</span>
                        <br>
                        Price
                    </a>
                </li>
            </ul>
            <hr>
            <ul>
                <li class="active">
                    <a href="#" title="Start Date">
                        <span class="h5 ">{{ $course->start_date->format('Y-m-d') }}</span>
                        <br>
                        Start Date
                    </a>
                </li>
                <li>
                    <a href="#" title="End Date">
                        <span class="h5 ">{{ $course->end_date ? $course->end_date->format('Y-m-d') : '' }}</span>
                        <br>
                        End Date
                    </a>
                </li>
                <li>
                    <a href="#" title="Course Lessons">
                        <span class="h5">{{ $course->lessons->count() }}</span>
                        <br>
                        Lessons
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
