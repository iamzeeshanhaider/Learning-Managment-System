<div>
    <label for="course_id" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select {{ $readonly ? 'disabled' : '' }}
            @if ($isWire) wire:model.lazy="course_id" @else name="{{ $allowMultiple ? 'courses[]' : 'course_id' }}" @endif
            @if ($allowMultiple) multiple @endif {{-- style="height:200px;" --}} required id="course_id"
            class="form-control">
            @if (!$allowMultiple)
                <option value="">@lang('Select Course')</option>
            @endif
            @foreach ($courses as $course)
                <option class="py-1" value="{{ $course->id }}"
                    @isset($selected)
                    {{ $allowMultiple && is_array($selected) ? (in_array($course->id, $selected) ? 'selected' : '') : ($course->id === $selected ? 'selected' : '') }}
                    @endisset>
                    {{ ucwords($course->title) }}</option>
            @endforeach
        </select>
    </div>
    @if ($readonly)
        <input type="hidden" name="{{ $allowMultiple ? 'courses[]' : 'course_id' }}" value="{{ $selected }}" />
    @endif
</div>
