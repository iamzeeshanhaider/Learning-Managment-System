<div>
    <label for="folder-select" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select required @if ($isWire) wire:model.lazy="folder_id" @else name="folder_id" @endif
            id="folder-select" class="form-control">
            @if (count($folders))
                <option value="" selected disabled>@lang('--- Select Folder ---')</option>
                @foreach ($folders as $folder)
                    <option value="{{ $folder->id }}" class="text-capitalize"
                        @isset($selected) {{ is_selected($folder->id, $selected->id) }} @endisset>
                        {{ $folder->name }}</option>
                @endforeach
            @else
                <option value="" selected disabled>@lang('--- No Folder Selected ---')</option>
            @endif
        </select>
    </div>
    @error('folder_id')
        <span class="text-danger small">{{ $message }}</span>
    @enderror
</div>
