$(document).on('click', '#otherTypeToggle', function() {
    $('.otherType').toggle('fast');
});

$('.asManyAsUnit').on('change', 'input[type="checkbox"]', function () {
    if ($(this).is(':checked')) {
        var unitNumber = $(this).closest('.unit').find('.unitName .number input').val();
        $(this).closest('.stuffListItem').find('.number input').attr('readonly', 'readonly').val(unitNumber);
    } else {
        $(this).closest('.stuffListItem').find('.number input').removeAttr('readonly');
    }
});

// squad line number change
$('.squad_line_new').ready(function(){
    $('.unit .unitName .number input').each(function () {
        if ($(this).val()) {
            $(this).trigger('change');
        }
    });
});
$('.unit .unitName .number').on('change', 'input', function() {
    var stuffList = $(this).closest('.unit').find('.stuffList');
    if ($(this).val() > 0) {
        stuffList.fadeTo('slow', '1');
        stuffList;
    } else {
        stuffList.fadeTo('slow', '.2');
    }
    return false;
});
