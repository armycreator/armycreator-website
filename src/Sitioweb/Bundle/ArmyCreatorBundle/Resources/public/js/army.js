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
                        )
                    });
                }
            }

        }).disableSelection();
    }

    $('.share-tooltip').on('click', function() {
        $(this).toggleClass('active');
        $(this).next('.share-tooltip-content').toggleClass('visible');
        toggleShare();

        return false;
    });

    $('#army-share-checkbox').on('change', function() {
        toggleShare();
        if ($(this).is(':checked')) {
            var action = 'share';
        } else {
            var action = 'dont-share';
        }

        $.ajax({
            type: "post",
            url: Routing.generate('army_toggle_share', { "slug": armycreator.armySlug }),
            data: { "action": action }
        });
    });

    function toggleShare() {
        if ($('#army-share-checkbox').is(':checked') && $('.share-tooltip').hasClass('active')) {
            $('.addthis_toolbox').show();
        } else {
            $('.addthis_toolbox').hide();
        }
    }

    //var addthis_config = {"data_track_addressbar":true};
    if ($('.addthis_toolbox').length > 0) {
        $.getScript("//s7.addthis.com/js/300/addthis_widget.js#pubid=olynk");
    }

    $('.squadLine').on('click', '.stuffList-toggle-all', function () {
        $('.stuffList-toggle').toggle();
    });

    $('.stuffList-toggle-link').on('click', function () {
        if ($(this).parent().prev('.stuffList-toggle').length > 0) {
            $(this).parent().prev('.stuffList-toggle').toggle();
        } else {
            $(this).parent().next('.stuffList-toggle').toggle();
        }
        $(this).find('.el-icon-caret-up, .el-icon-caret-down').toggle();
    });

    $('.stuffList-hide-all').on('click', function () {
        $('.stuffList-toggle, .stuffList-toggle-link .el-icon-caret-up').hide();
        $('.stuffList-toggle-link .el-icon-caret-down').show();
    });

    $('.stuffList-show-all').on('click', function () {
        $('.stuffList-toggle, .stuffList-toggle-link .el-icon-caret-up').show();
        $('.stuffList-toggle-link .el-icon-caret-down').hide();
    });
});
