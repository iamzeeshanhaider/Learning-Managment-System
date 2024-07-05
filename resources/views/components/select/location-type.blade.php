<div>
    <label for="location_type" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select required name="type" id="location_type" class="form-control">
            <option value="" selected disabled>@lang('Select Location Type')</option>
            @foreach ($loc_types as $type)
                <option
                    value="{{ $type }}"
                    class="text-capitalize"
                    @isset($selected) {{ is_selected($type, $selected) }} @endisset
                >{{ ucwords($type) }}</option>
            @endforeach
        </select>
    </div>
</div>
