<div>
    <label for="category_id" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select name="category_id" required id="category_id" class="form-control" {{ $readonly ? 'disabled' : '' }}>
            <option value="" selected disabled>@lang('Select Category')</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @isset($selected) {{ is_selected($category->id, $selected) }} @endisset>
                    {{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    @if ($readonly)
    <input type="hidden" name="category_id" value="{{ $selected }}" />
    @endif
</div>
