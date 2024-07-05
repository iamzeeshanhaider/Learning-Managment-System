<div class="comments">
    @foreach ($ticket->comments as $comment)
        @if ($user->id === $comment->user_id)
            <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                <div>
                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">{{ $comment->user->name }}
                    </p>
                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">{{ $comment->comment }}</p>
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
                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">{{ $comment->comment }}
                    </p>
                    <p class="small ms-3 mb-3 rounded-3 text-muted">{{ $comment->created_at->format('Y-m-d') }}</p>
                </div>
            </div>
        @endif
    @endforeach
</div>





<script>
    $(document).ready(function() {

        var userId = "{{ auth()->user()->id }}";
        $('html, body').animate({
            scrollTop: $(document).height()
        }, 1000);


        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: 'ap2'
        });


        var channel = pusher.subscribe('comments');
        channel.bind('comment_push', function(data) {
            debugger;
            let comment = data;
            const panelBody1 = `<div class="d-flex flex-row justify-content-end mb-4 pt-1">
                <div>
                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">${ comment.user.name }</p>
                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">${comment.comment}</p>
                    <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">${comment.created_at.substr(0, 10)}</p>
                </div>
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava4-bg.webp"
                    alt="avatar 1" style="width: 45px; height: 100%;">
                </div>`;
            const panelBody2 = `<div class="d-flex flex-row justify-content-start">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3-bg.webp"
                    alt="avatar 1" style="width: 45px; height: 100%;">
                <div>
                    <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">${ comment.user.name }</p>
                    <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">${comment.comment}</p>
                    <p class="small ms-3 mb-3 rounded-3 text-muted">${comment.created_at.substr(0, 10)}</p>
                </div>
                </div>`;
            const panel = parseInt(comment.user.id) === parseInt(userId) ? panelBody1 : panelBody2;

            $('.comments').append(panel);
            $('html, body').animate({
            scrollTop: $(document).height()
        }, 1000);
        });

    });
</script>
