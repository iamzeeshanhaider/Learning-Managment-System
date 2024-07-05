<div class="btn-group">
    @can('update', $row->id)
        <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary"
            data-link="{{ route('tickets.edit', $row->slug) }}" title="Edit Ticket">
            <i class="fa fa-edit"></i>
        </a>
    @endcan

    <a class="text-white btn btn-sm btn-primary" href="{{ route('tickets.show', $row->slug) }}" title="Comments">
        <i class="fa fa-comments"></i> Comments ({!! formatCount($row->comments_count) !!})
    </a>

        {{-- <x-buttons.delete
        :action="route('tickets.destroy', $row->slug)"
        title="Are you sure you want to delete this Ticket Category?"
    /> --}}
</div>
