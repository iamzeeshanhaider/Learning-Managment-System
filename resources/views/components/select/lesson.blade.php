<div>
    <label for="lesson" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select name="lesson_id" required id="lesson" class="form-control" {{ $readonly ? 'disabled' : '' }}>
            @if (!count($lessons))
            <option value="" selected disabled>-- You need to Create Lessons First --</option>
            @else
            <option value="" selected disabled>@lang('Select Lesson')</option>
            @foreach ($lessons as $lesson)
                <option
                    value="{{ $lesson->id }}"
                    @isset($selected) {{ is_selected($lesson->id, $selected) }} @endisset
                >{{ ucwords($lesson->name) }}</option>
            @endforeach
            @endif
        </select>
    </div>
    @if ($readonly)
    <input type="hidden" name="lesson_id" value="{{ $selected }}" />
    @endif
</div>

