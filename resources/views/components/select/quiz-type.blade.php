<div>
    <label for="type" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select required name="type" id="type" class="form-control">
            @if (!count($quizTypes))
            <option value="" selected disabled>-- You need to Create Quiz Types --</option>
            @else
                <option value="">@lang('Select Quiz Type')</option>
                @foreach ($quizTypes as $type)
                    <option
                        value="{{ $type }}"
                        class="text-capitalize"
                        @isset($selected) {{ is_selected($type, $selected) }} @endisset
                    >{{ ucwords($type) }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
