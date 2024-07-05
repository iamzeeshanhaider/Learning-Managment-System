<div class="card">
    <div class="card-body">

        <h5 class="mt-3 card-title">Name:</h5>
        <span class="card-title">{!! $batch->name !!}</span>

        <h5 class="mt-3 card-title">Description:</h5>
        <span class="card-title">{!! $batch->description !!}</span>

        <div class="weather-category twt-category">
            <hr>
            <ul>
                <li>
                    <a href="#" title="Linked Courses">
                        <span class="h5">{{ $batch->students->count() }}</span>
                        <br>
                        Enrolled Students
                    </a>
                </li>
                <li>
                    <a href="#" title="">
                        {{--  --}}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
