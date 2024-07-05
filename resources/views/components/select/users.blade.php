<div>
    <label for="select2-dropdown" class="mb-1 control-label">{{ ucwords($label ?? $group) }}</label>
    <div class="input-group">
        <select name="{{ $name }}" id="select2-dropdown" {{ $readonly ? 'disabled' : '' }}
            @if ($allowMultiple) multiple="multiple" {{-- style="height:200px;" --}} @endif
            @if ($required) required @endif
            class="form-control js-select2">
            @if (!$allowMultiple)
                <option value="">@lang('Select') {{ ucwords($group) }}</option>
            @endif
            @forelse ($users as $user)
                <option value="{{ $user->id }}" class="py-1"
                    @isset($selected)
                {{ $allowMultiple && is_array($selected) ? (in_array($user->id, $selected) ? 'selected' : '') : ($user->id === $selected ? 'selected' : '') }}
                @endisset>
                    {{ ucwords($user->name) }} {{ ucwords($user->lname) }}
                </option>>
            @empty
                <option value="" selected disabled>-- You need to Create {{ ucwords($group) }}'s First --</option>
            @endforelse
        </select>
    </div>
    @if ($readonly)
        <input type="hidden" name="{{ $name }}" value="{{ $selected }}" />
    @endif
</div>
