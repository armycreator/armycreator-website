$(function() {
    if (!armycreator.externalUser) {
        $('.squadList').sortable({
            connectWith: '.squadList',
            placeholder: 'squad droppableHover',
            handle: '.moveButton',
            update: function (event, ui) {
                var item = $(ui.item);
                var oldUnitTypeId = item.closest('.unitTypeList').attr('id');
                var newUnitType = $(this).closest('.unitTypeList');
                var newUnitTypeId = newUnitType.attr('id');

                if (oldUnitTypeId == newUnitTypeId) {
                    // test previous
                    var prev = item.prev();
                    if (prev && !prev.hasClass('squad')) {
                        item.insertBefore(prev);
                    }

                    // save
                    var unitType = newUnitType.attr('data-unitType');
                    var breed = newUnitType.attr('data-breed');

                    $.ajax({
                        url: Routing.generate(
                            'squad_move',
                            {
                                "armySlug": armycreator.armySlug,
                                "squadId": item.attr('data-squadId'),
                                "unitTypeSlug": unitType,
                                "breedSlug": breed,
                                "position": item.prevAll('.squad').length
                            }
                        ),
                    });
                }
            }

        }).disableSelection();
    }

    $('.share-tooltip').on('click', function() {
        $(this).toggleClass('active');
        $(this).next('.share-tooltip-content').toggleClass('visible');
        toggleShare();
    });

    $('#army-share-checkbox').on('change', function() {
        toggleShare();
        if ($(this).is(':checked')) {
            var action = 'share';
        } else {
            var action = 'dont-share';
        }

        $.ajax({
            url: Routing.generate('army_share', { "action": action });
        });
    });

    function toggleShare() {
        if ($('#army-share-checkbox').is(':checked') && $('.share-tooltip').hasClass('active')) {
            $('.addthis_toolbox').show();
        } else {
            $('.addthis_toolbox').hide();
        }
    }
});
