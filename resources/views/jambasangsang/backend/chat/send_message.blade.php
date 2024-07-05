<div class="panel panel-default">
    <div class="panel-body">
        <div class="comment-form">

            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                <textarea class="text-box-send-message form-control" id="comment" name="comment" placeholder="Write Something ... "></textarea>

                @if ($errors->has('comment'))
                    <span class="help-block">
                        <strong>{{ $errors->first('comment') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#comment').focus();
        $("#comment").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                var commentUrl = "{{ url('message') }}";
                debugger;
                var message = $("#comment").val();
                console.log(message);
                $.ajax({
                    type: "post",
                    url: commentUrl,
                    data: {
                        _token: "{{ csrf_token() }}",
                        message: message
                    },
                    success: function(store) {
                        $("#comment").val("");
                        // location.href = store;
                    },
                    error: function() {}
                });
            }
        });
    });
</script>
