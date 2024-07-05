@props([
    'id' => -1,
    'action' => '',
    'buttonClass' => 'btn btn-sm btn-danger',
    'title' => 'Are you sure?',
    'description' => 'Do you really want to delete these records? This process cannot be undone.',
])

<div class="" id="{{ $id }}">
    <button class="{{ $buttonClass }}" data-toggle="modal" data-target="#deleteModal">
        <i class="fa fa-trash"></i>
    </button>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="border-0 modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ $action }}" method="post" class="p-3 text-center "
                    onsubmit="$('#delete-button').attr('disabled', true)">
                    @csrf
                    @method('DELETE')

                    <div class="icon-box">
                        <i class="fa fa-times"></i>
                    </div>

                    <h4 class="py-2 modal-title w-100">{{ $title }}</h4>

                    <div class="modal-body">
                        <p>{{ $description }}</p>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger" id="delete-button">Yes, Proceed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>

</style>
