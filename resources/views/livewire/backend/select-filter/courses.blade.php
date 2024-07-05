<div>
    <a href="{{ request()->fullUrlWithQuery(['course' => 'all']) }}" title="{{ __('All Students') }}"
        class="dropdown-item {{ isset($selected) && $selected === 'all' ? 'text-success' : '' }}">{{ __('All Students') }} (*)</a>

    @forelse ($courses as $course)
        <a href="{{ request()->fullUrlWithQuery(['course' => $course->slug]) }}" title="{{ $course->title }}"
            class="dropdown-item {{ isset($selected) && $selected === $course->slug ? 'text-success' : '' }}">{{ str_limit($course->title, 80) }} ({!! formatCount($course->students->count()) !!})</a>
    @empty
        <a class="dropdown-item">
            <span class="">No Course found</span>
        </a>
    @endforelse
</div>
