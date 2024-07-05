<div>
    <label for="status" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select name="status" required id="status" class="form-control">
            <option value="" selected disabled>@lang('Select Status')</option>
            @foreach ($status_list as $status)
                <option
                    value="{{ $status }}"
                    @isset($selected) {{ is_selected($status, $selected) }} @endisset
                >{{ ucwords($status) }}</option>
            @endforeach
        </select>
    </div>
</div>
