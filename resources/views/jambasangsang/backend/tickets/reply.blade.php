<div class="panel panel-default">
    <div class="panel-heading">Send Message</div>

    <div class="panel-body">
        <div class="comment-form">

            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                <textarea rows="10" id="comment" class="form-control" name="comment"></textarea>

                @if ($errors->has('comment'))
                    <span class="help-block">
                        <strong>{{ $errors->first('comment') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <button id="save" class="btn btn-primary">Send</button>
            </div>

        </div>
    </div>
</div>


<script>
    $("#save").click(function() {
        var commentUrl = "{{ url('comment') }}";
        var ticketId = "{{ $ticket->id }}";
        $.ajax({
            type: "post",
            url: commentUrl,
            data: {
                _token: "{{ csrf_token() }}",
                ticket_id: ticketId,
                comment: $("#comment").val()
            },
            success: function(store) {
                $("#comment").val("")
                // location.href = store;
            },
            error: function() {}
        });
    });
</script>
