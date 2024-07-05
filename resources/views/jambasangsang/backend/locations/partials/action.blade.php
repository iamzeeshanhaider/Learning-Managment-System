<div class="btn-group">
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('locations.edit', $row->slug) }}" title="Edit Location">
        <i class="fa fa-edit"></i>
    </a>
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('locations.show', $row->slug) }}" title="Preview">
        <i class="fa fa-eye"></i>
    </a>

    @if ($row->status === \App\Enums\GeneralStatus::Enabled)
        <x-buttons.delete :action="route('locations.destroy', $row->slug)" title="Are you sure you want to delete this Location?" />
    @endif
</div>
