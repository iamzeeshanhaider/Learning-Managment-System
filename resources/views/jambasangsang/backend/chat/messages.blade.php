<div class="messages">
    @foreach ($messages as $comment)
        @if (auth()->user()->id === $comment->created_by_id)
            <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                <div>
                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">{{$comment->user->name }}
                    </p>
                    <pre class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">{{  $comment->message }}</pre>
                    <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">
                        {{ $comment->created_at->format('Y-m-d') }}</p>
                </div>
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp" alt="avatar 1"
                    style="width: 45px; height: 100%;">
            </div>
        @else
            <div class="d-flex flex-row justify-content-start">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp" alt="avatar 1"
                    style="width: 45px; height: 100%;">
                <div>
                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">
                        {{ $comment->user->name }}</p>
                    <pre class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">{{ $comment->message }}
                    </pre>
                    <p class="small ms-3 mb-3 rounded-3 text-muted">{{ $comment->created_at->format('Y-m-d') }}</p>
                </div>
            </div>
        @endif
    @endforeach
</div>





<script>
    $(document).ready(function() {
        var userId = "{{ auth()->user()->id }}";
        var element = $('.chat-window-content');
        element.scrollTop(element.prop("scrollHeight"));
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: 'ap2'
        });


        var channel = pusher.subscribe('live-chat-broadcast');
        channel.bind('chat_push', function(data) {
            debugger;
            let message = data;
            let message_string  = message.message.replace(/\n/g, "<br>");
            const panelBody1 = `<div class="d-flex flex-row justify-content-end mb-4 pt-1">
                <div>
                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">${ message.user.name }</p>
                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">${message_string}</p>
                    <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">${message.created_at.substr(0, 10)}</p>
                </div>
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp"
                    alt="avatar 1" style="width: 45px; height: 100%;">
                </div>`;
            const panelBody2 = `<div class="d-flex flex-row justify-content-start">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                    alt="avatar 1" style="width: 45px; height: 100%;">
                <div>
                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">${ message.user.name }</p>
                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary" >${message_string}</p>
                    <p class="small ms-3 mb-3 rounded-3 text-muted">${message.created_at.substr(0, 10)}</p>
                </div>
                </div>`;
            const panel = parseInt(message.user.id) === parseInt(userId) ? panelBody1 : panelBody2;

            $('.messages').append(panel);
            element.scrollTop(element.prop("scrollHeight"));

        });

    });
</script>
