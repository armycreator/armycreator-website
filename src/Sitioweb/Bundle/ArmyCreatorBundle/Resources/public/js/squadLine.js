$(document).ready(function() {
    if ($('#websiteContent').attr('class').match(/^squad_/)) {
        $('.asManyAsUnit')
            .on('change', 'input[type="checkbox"]', function () {
                if ($(this).is(':checked')) {
                    var unitNumber = $(this).closest('.unit').find('.unitName .number input').val();
                    $(this).closest('.stuffListItem').find('.number input').attr('readonly', 'readonly').val(unitNumber);
                } else {
                    $(this).closest('.stuffListItem').find('.number input').removeAttr('readonly');
                }
                calculateTotalPoints();
            })
            .on('click', '.toggleAmau', function() {
                $(this).prev().trigger('click');
                $(this).toggleClass('highlight');
            })
            .ready(function() {
                $('input[type="checkbox"]').each(function() {
                    if ($(this).attr('checked')) {
                        $(this).next().addClass('highlight');
                    }
                    $(this).hide();
                });
            });

        $('.unit .stuffListItem .number')
            .on('click', '.toZero', function () {
                $(this).closest('.stuffListItem').find('.toggleAmau.highlight').trigger('click');
                $(this).prev().val(0);
                calculateTotalPoints();
            });


        // squad line number change
        $('.squad_line_new').ready(function(){
            $('.unit .unitName .number input').each(function () {
                if ($(this).val()) {
                    $(this).trigger('change');
                }
            });
        });

        $('.unit .unitName .number')
            .on('change', 'input', function() {
                // opacity if < 0
                var stuffList = $(this).closest('.unit').find('.stuffList');
                var newNb = $(this).val();
                if (newNb > 0) {
                    stuffList.fadeTo('slow', '1');
                } else {
                    stuffList.fadeTo('slow', '.2');
                }

                // value if "as many" selected
                stuffList.find('.asManyAsUnit input:checked').each(function () {
                    $(this).closest('.stuffListItem').find('.number input').val(newNb);
                });


                return false;
            });

        $('.unit .unitName .number, .unit .stuffListItem .number')
            .on('change', 'input[data-points]', function() {
                    calculateTotalPoints();
            });


        calculateTotalPoints = function() {
            var total = 0;
            $('#websiteContent input[data-points]').each(function() {
                var nb = parseInt($(this).val());

                if (nb > 0) {
                    total += nb * parseInt($(this).attr('data-points'));
                }
            });
            $('.squadTotal').text(total);
        }
    }
});
