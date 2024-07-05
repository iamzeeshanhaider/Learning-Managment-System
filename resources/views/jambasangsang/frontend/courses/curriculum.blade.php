<div class="tab-pane fade" id="curriculam" role="tabpanel" aria-labelledby="curriculam-tab">
    <div class="curriculam-cont">
        <div class="title">
            <h6>
                {{ $course->course_master->name }}
               {{-- @if ($course->start_date->isPast())
                    <span class="text-success">@lang(' Lecture Started')</span>
                @else
                    @lang(' Lecture Will Start in ')<span class="iro-countdown"
                        data-expire="{{ $course->start_date }}">{{ $course->start_date->diffForHumans() }}</span>
                @endif--}}
            </h6>
        </div>
        <div class="accordion" id="accordionExample">
            <h4>Lessons</h4>
            @foreach ($course->lessons as $key => $lesson)
                <div class="card">
                    <div class="card-header" id="headingOne{{ $lesson->id }}">
                        <a href="#" data-toggle="collapse" data-target="#collapseOne{{ $lesson->id }}"
                            aria-expanded="true" aria-controls="collapseOne">
                            <ul>
                                <li><i class="fa fa-file-o"></i></li>
                                <li>
                                    <span class="lecture"> @lang('Lecture'){{ $key+1 }}</span>
                                </li>
                                <li>
                                    <span class="head">{{ $lesson->title }}</span>
                                </li>
                                <li>
                                    <span class="time d-none d-md-block">
                                        <i class="fa fa-clock-o"></i>
                                        <span> {{ $course->duration() }}</span>
                                    </span>
                                </li>
                            </ul>
                        </a>
                    </div>

                    <div id="collapseOne{{ $lesson->id }}" class="collapse {{ $key == 0 ? 'show' : '' }}"
                        aria-labelledby="headingOne{{ $lesson->id }}" data-parent="#accordionExample">
                        {{-- <div class="card-body">
                        <p>{!! $lesson->content !!}</p>
                    </div> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div> <!-- curriculam cont -->
</div>
