<div class="card">
    <div class="card-body">

        <h5 class="mt-3 card-title">Image:</h5>
        <img src="{{ $category->image() }}" alt="" width="200px" height="200px" style="object-fit: contain">

        <h5 class="mt-3 card-title">Name:</h5>
        <span class="card-title">{!! $category->name !!}</span>

        <h5 class="mt-3 card-title">Description:</h5>
        <span class="card-title">{!! $category->description !!}</span>

        <div class="weather-category twt-category">
            <hr>
            <ul>
                <li class="active">
                    <a href="#" title="Status">
                        <span class="h6 text-{{ $category->status_color() }}">{{ $category->status }}</span>
                        <br>
                        Status
                    </a>
                </li>
                <li>
                    <a href="#" title="Linked Courses">
                        <span class="h5">{{ $category->courses_master->count() }}</span>
                        <br>
                        Courses
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
