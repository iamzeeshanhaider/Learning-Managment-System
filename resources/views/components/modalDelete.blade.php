@props([
    'title' => 'Confirm you want to delete this item',
    'description' => 'This action cannot be undone',
    'route' => '',
    'index' => '-0',
])

<div class="modal fade" id="deleteModal-{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
        <form class="modal-content" action="{{ $route }}" method="post">
            @csrf
            @method('DELETE')

            <div class="modal-header">
                <h5 class="modal-title" id="staticModalLabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>
                    {{ $index }}
                    {{ $title }}
                </p>
                <p><small>{{ $description }}</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
