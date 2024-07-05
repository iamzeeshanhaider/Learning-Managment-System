<div>
    <label for="modules" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select required name="module_id" id="modules" class="form-control" {{ $readonly ? 'disabled' : '' }}>
            <option value="" selected disabled>@lang('Select Module')</option>
            @forelse ($modules as $module)
                <option value="{{ $module->id }}"
                    @isset($selected) {{ is_selected($module->id, $selected) }} @endisset>
                    {{ $module->name }}
                </option>
            @empty
                <option value="" selected disabled>-- You need to Create Modules First --</option>
            @endforelse
        </select>
    </div>
    @if ($readonly)
        <input type="hidden" name="module_id" value="{{ $selected }}" />
    @endif
</div>
