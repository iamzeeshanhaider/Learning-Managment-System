<div class="card">
    <div class="card-body">

        <div class="col-12">
            <h6 class="mt-3 card-title">Subject: {{$chat_request->issue}} </h6>
        </div>


        <div class="col-12">
            <pre>{{ $chat_request->chat_string }}</pre>
        </div>


        <div class="weather-category twt-category">
            <hr>
            <ul>
                <li class="active">
                    <a href="#" title="Model">
                        <span class="h6">{{ $chat_request->status }}</span>
                        <br>
                        status
                    </a>
                </li>
                <li>
                    <a href="#" title="User">
                        <span class="h5">{{ $chat_request->created_by->name }}</span>
                        <br>
                        User
                    </a>
                </li>
                <li class="active">
                    <a href="#" title="Date">
                        <span class="h6">{{ $chat_request->created_at }}</span>
                        <br>
                        Date
                    </a>
                </li>
            </ul>
        </div>
        <form
            action="{{ route('chat_requests.update', $chat_request->id) }}"
            method="post" novalidate="novalidate" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mt-3 col-12">
                <x-select.users
                    group="Instructor"
                    name="assigned_to_id"
                    :selected="isset($chat_request->assigned_to_id) ? $chat_request->assigned_to_id : old('assigned_to_id')" />
            </div>
            <div class="mt-3 col-12">
                <x-select.status
                    :selected="isset($chat_request->status)
                        ? $chat_request->status
                        : old('status')" />
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
