<div>
    <label for="batch" class="mb-1 control-label">{{ $label }}</label>
    <div class="input-group">
        <select {{ $required ? 'required' : '' }} {{ $multiple ? 'multiple' : '' }} {{ $readonly ? 'readonly' : '' }}
            @if ($isWire) wire:model.lazy="batch_id" @else name="batch_id" @endif id="batch"
            class="form-control">
            @if (!count($batches))
                <option value="" selected disabled>-- You need to create Batches first --</option>
            @else
                <option value="" selected disabled>@lang('Select Batch')</option>
                @foreach ($batches as $batch)
                    <option value="{{ $batch->id }}"
                        {{ $multiple && is_array($selected) ? (in_array($batch->id, $selected) ? 'selected' : '') : ($batch->id === $selected ? 'selected' : '') }}
                    >
                        {{ $batch->name }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>
