<div class="card">
    <div class="card-body">
        <div class="weather-category twt-category">
            <ul>
                <li class="active">
                    <a href="#" title="Quiz">
                        <span class="h5 text-dark">{{ $quiz->title }}</span>
                        <br>
                        Quiz Title
                    </a>
                </li>
                <li>
                    <a href="#" title="Manage Lesson Resources">
                        <span class="h5 text-dark">{{ $quiz->description }}</span>
                        <br>
                        Description
                    </a>
                </li>
                <li>
                    <a href="#" title="Manage Lesson Resources">
                        <span class="h5 text-dark">{{ $quiz->questions->count() }}</span>
                        <br>
                        Number of Questions
                    </a>
                </li>
            </ul>
            <hr>
            <ul>
                <li class="active">
                    <a href="{{ route('submission.index', $quiz->slug) }}" title="Quiz">
                        <span class="h5 text-dark">{{ $quiz->submissionsCount() }}</span>
                        <br>
                        Submissions
                    </a>
                </li>
                <li>
                    <a href="#" title="Manage Lesson Resources">
                        <span class="h5 text-dark">{{ $quiz->attempts }}</span>
                        <br>
                        Allowed Attempts
                    </a>
                </li>
                <li>
                    <a href="#" title="Manage Lesson Resources">
                        <span class="h5 text-dark">{{ $quiz->obtainable_points }}</span>
                        <br>
                        Obtainable Points
                    </a>
                </li>
            </ul>
            <hr>
            <ul>
                <li>
                    <a href="#" title="Manage Lesson Resources">
                        <span class="h6 text-dark">{{ $quiz->batch->name }}</span>
                        <br>
                        Batch
                    </a>
                </li>
                <li>
                    <a href="#" title="Manage Lesson Resources">
                        <span class="h5 text-dark">{{ $quiz->is_average ? 'Average' : 'Latest Attempt' }}</span>
                        <br>
                        Final Score
                    </a>
                </li>
                <li>
                    <a href="#" title="Manage Lesson Resources">
                        <span class="h5 text-dark">{{ gmdate('i:s', $quiz->duration) }}</span>
                        <br>
                        Duration
                    </a>
                </li>
            </ul>
            <hr>
            <ul>
                <li>
                    <a href="#" title="Manage Lesson Resources">
                        <span class="h6 text-{{ $quiz->status_color() }}">{{ $quiz->status_name }}</span>
                        <br>
                        Status
                    </a>
                </li>
                <li>
                    <a href="#" title="Manage Lesson Resources">
                        <span class="h5 text-success">{{ $quiz->start_time->format('Y-m-d') }}</span>
                        <br>
                        Start Date
                    </a>
                </li>
                <li>
                    <a href="#" title="Manage Lesson Resources">
                        <span
                            class="h5 {{ $quiz->end_time && $quiz->end_time->isFuture() ? 'iro-countdown text-success' : 'text-danger' }}"
                            data-expire="{{ $quiz->end_time ?? '' }}">{{ $quiz->end_time ? $quiz->end_time->format('Y-m-d') : '' }}</span>
                        <br>
                        End Date
                    </a>
                </li>
            </ul>
            <hr>
        </div>
    </div>
</div>
