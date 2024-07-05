<div class="btn-group">
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('ticket_category.edit', $row->slug) }}" title="Edit Ticket Category">
        <i class="fa fa-edit"></i>
    </a>

    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('ticket_category.show', $row->slug) }}" title="Preview Ticket Category">
        <i class="fa fa-eye"></i>
    </a>

    <a class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        href="{{ route('tickets.index', ['category' => $row->id]) }}" title="Preview Tickets">
        <i class="fa fa-ticket"></i> Tickets ({!! formatCount($row->tickets_count) !!})
    </a>

    <x-buttons.delete
        :action="route('ticket_category.destroy', $row->slug)"
        title="Are you sure you want to delete this Ticket Category?"
    />
</div>
