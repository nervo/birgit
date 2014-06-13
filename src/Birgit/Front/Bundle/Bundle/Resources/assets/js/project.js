require(['jquery'], function($) {
    $(function() {
        $('a.api').click(function(event) {
            $.ajax(event.target.href);
            event.preventDefault();
        });
    });
});
