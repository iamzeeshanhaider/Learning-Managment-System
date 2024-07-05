<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"
    integrity="sha512-lteuRD+aUENrZPTXWFRPTBcDDxIGWe5uu0apPEn+3ZKYDwDaEErIK9rvR0QzUGmUQ55KFE2RqGTVoZsKctGMVw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    (function($) {
        var JEREMIAHIRO_COUNTDOWN = {
            init: function() {
                this.jeremiahiro_countdown();
            },
            jeremiahiro_countdown: function() {
                if ($(".iro-countdown").length > 0) {
                    $(".iro-countdown").each(function(index, el) {
                        var _this = $(this),
                            _expire = _this.data('expire');
                        _this.countdown(_expire, function(event) {
                            $(this).html(event.strftime(
                                '<span>%D Day(s) %H:%M:%S</span>'
                            ));
                        });
                    });
                }
            },
        }

        window.onload = function() {
            JEREMIAHIRO_COUNTDOWN.init();
        }

    })(window.Zepto || window.jQuery, window, document);
</script>
