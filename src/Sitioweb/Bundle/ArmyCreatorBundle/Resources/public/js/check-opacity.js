$(function() {
    function triggerOpacity(item) {
        var target = $(item).closest('[data-opacity-target]');
        if ($(item).is(':checked') > 0) {
            target.fadeTo('slow', '1');
        } else {
            target.fadeTo('slow', '.3');
        }
    };

    $('[data-opacity-trigger]').on('change', function () {
        triggerOpacity(this);
    });

    $('[data-opacity-trigger]').each(function() {
        triggerOpacity(this);
    });
});
