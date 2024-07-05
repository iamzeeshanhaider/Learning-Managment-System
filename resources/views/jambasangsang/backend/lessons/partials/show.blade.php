<div class="card">

    <div class="card-body">
        <div class="col-6">
            <div class="text-left">
                <img class="mx-auto card-img-top" alt="{{ $lesson->name }}" src="{{ $lesson->image() }}" width="200px"
                    height="200px" style="object-fit: contain">
            </div>
            <p class="card-text">Name:</p>
            <h5 class="card-title">{{ $lesson->name }}</h5>
        </div>
        <div class="col-6">
            <p class="card-text">Outcome:</p>
            <span>{!! $lesson->outcome !!}</span>
        </div>
        <div class="weather-category twt-category">
            <ul>
                <li>
                    <a href="{{ route('lesson.resource.index', $lesson->slug) }}" title="Linked Courses">
                        <span class="h6">{{ $lesson->resources->count() }}</span>
                        <br>
                        Resources <i class="fa fa-plus btn btn-sm btn-primary" title="Add Resources"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
