$(function() {
    $('[data-breed-id]').on('click', function () {
        $('#ac_armytype_breed').val($(this).attr('data-breed-id'));

        $(this).closest('ul').find('a').removeClass('soft');
        $(this).addClass('soft');
        return false;
    });
});
