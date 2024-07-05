<div>
    <label for="location" class="mb-1 control-label">@lang('Location')</label>
    <div class="input-group">
        <select name="location_id" required id="location" class="form-control">
            <option value="">@lang('Select Location')</option>
            @forelse ($locations as $location)
                <option value="{{ $location->id }}"
                    @isset($selected) {{ is_selected($location->id, $selected) }} @endisset>
                    {{ ucwords($location->name) }} ({{ $location->seat_capacity ?? '' }})</option>
            @empty
                <option value="" selected disabled>-- You need to Create Locations First --</option>
            @endforelse
        </select>
    </div>
</div>
