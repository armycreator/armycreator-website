$(function() {
    function selectStuff (sstuff) {
        var defaultPoints, defaultAuto, selectedOption;

        selectedOption = $(sstuff).find('[value="' + $(sstuff).val() + '"]');

        $('#armycreator_unitstufftype_points').val(selectedOption.attr('data-default-points'));
        $('#armycreator_unitstufftype_auto').prop('checked', !!parseInt(selectedOption.attr('data-default-auto')));
    };

    selectStuff($('[data-ac-type="stuff"]'));

    $('[data-ac-type="stuff"]').on('change', function () {
        selectStuff($(this));
    });
});
