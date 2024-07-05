<div>
    <label for="category" class="mb-1 control-label">{{ $label }}</label>
    <select required name="category_id" id="category" class="form-control @error('category') is-invalid @enderror">
        <option selected disabled value="">@lang('Select Category')</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                @isset($selected) {{ is_selected($category->id, $selected) }} @endisset>
                {{ $category->name }}</option>
        @endforeach
    </select>
</div>
