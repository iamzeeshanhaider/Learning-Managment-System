<div>
    <label for="role" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select required name="role" id="role" class="form-control">
            <option value="" selected disabled>@lang('Select Role')</option>
            @foreach ($roles as $role)
                <option
                    value="{{ $role->id }}"
                    {{ !$selected && $loop->first ? 'selected' : '' }}
                    class="text-capitalize"
                    {{ ($role->name == $group) ? 'selected' : ($role->name === $selected ? 'selected' : '')  }}
                >{{ ucwords($role->name) }}</option>
            @endforeach
        </select>
    </div>
</div>
