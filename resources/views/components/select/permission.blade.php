<div>
    <label for="permissions" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select multiple name="permissions[]" id="permissions" class="form-control" style="height:200px;">
            @foreach ($permissions as $permission)
                <option
                    value="{{ $permission->id }}"
                    class="text-capitalize"
                    @isset($selected) {{ in_array($permission->name, $selected) ? 'selected' : '' }} @endisset
                >{{ ucwords(str_replace('_', ' ', $permission->name)) }}</option>
            @endforeach
        </select>
    </div>
</div>
