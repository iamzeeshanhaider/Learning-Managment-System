<div>
    <label for="course_master" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select name="course_master_id" required id="course_master" class="form-control" {{ $readonly ? 'disabled' : '' }}>
            <option value="">@lang('Select Course Master')</option>
            @foreach ($course_masters as $course_master)
                <option
                    value="{{ $course_master->id }}"
                    @isset($selected) {{ is_selected($course_master->id, $selected) }} @endisset
                >{{ ucwords($course_master->name) }}</option>
            @endforeach
        </select>
    </div>
    @if ($readonly)
    <input type="hidden" name="course_master_id" value="{{ $selected }}" />
    @endif
</div>
