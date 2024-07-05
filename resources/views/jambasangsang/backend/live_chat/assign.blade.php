<div class="card">
    <div class="card-body">
        <form action="{{ route('chat_requests.update', $chat->chat_id) }}" method="post" novalidate="novalidate"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mt-3 col-12">
                <x-select.users name="assigned_to_id" group="Instructor" :selected="isset($chat->chat->assigned_to_id) ? $chat->chat->assigned_to_id : old('assigned_to_id')" />
            </div>

            <div class="mt-3 col-12">
                <x-select.status :selected="isset($chat->chat->status) ? $chat->chat->status : old('status')" />
            </div>

            <div class="mt-3 col-12">
                <button id="update-chat-request" type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-save fa-lg"></i>&nbsp;
                    <span id="assign_request_to_instructor">@lang('Save')</span>
                </button>
            </div>
        </form>
    </div>
</div>
