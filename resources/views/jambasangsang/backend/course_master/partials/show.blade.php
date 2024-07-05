<div class="card">
    <div class="card-body">
        <h5 class="mt-3 card-title">Name:</h5>
        <span class="card-title">{{ $courseMaster->name }}</span>

        <h5 class="mt-3 card-title">Descriptions:</h5>
        <span class="card-title">{!! $courseMaster->description !!}</span>

        <div class="weather-category twt-category">
            <hr class="py-2">
            <ul>
                <li class="active">
                    <a href="#" title="Status">
                        <span class="h6 text-{{ $courseMaster->status_color() }}">{{ $courseMaster->status }}</span>
                        <br>
                        Status
                    </a>
                </li>
                <li>
                    <a href="{{ route('courses.index', ['cm' => $courseMaster->slug]) }}" title="Linked Courses">
                        <span class="h6 count">{!! formatCount($courseMaster->courses->count()) !!}</span>
                        <br>
                        Courses <i class="fa fa-plus btn btn-sm btn-primary" title="Add Course"></i>
                    </a>
                </li>
                <li>
                    <a href="#" title="Linked Category">
                        <span class="h6">{{ $courseMaster->category->name }}</span>
                        <br>
                        Category
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
