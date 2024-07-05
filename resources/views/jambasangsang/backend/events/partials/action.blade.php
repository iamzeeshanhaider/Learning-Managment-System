<div class="btn-group">
    <a onclick="handleGeneralModal(this)"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('events.edit', $row->slug) }}" title="Edit Event">
        <i class="fa fa-edit"></i>
    </a>

    <a onclick="handleGeneralModal(this)"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('events.show', $row->slug) }}" title="View Event">
        <i class="fa fa-eye"></i>
    </a>

    @if ($row->status === \App\Enums\GeneralStatus::Enabled)
        <x-buttons.delete :action="route('events.destroy', $row->slug)" title="Are you sure you want to delete this Item?" />
    @endif

</div>
