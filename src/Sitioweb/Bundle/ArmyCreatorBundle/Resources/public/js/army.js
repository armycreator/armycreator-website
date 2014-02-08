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
});
