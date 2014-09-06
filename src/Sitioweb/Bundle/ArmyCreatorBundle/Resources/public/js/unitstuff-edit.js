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



    fuzzysearch = $('[data-fuzzysearch]').map(function () {
        return $(this).attr('data-fuzzysearch').trim();
    }).toArray();

    $('input[data-fuzzyfilter]').on('change, keydown', function () {
        var filter = $(this).val();

        if (!filter) {
            $('[data-fuzzysearch]').show();
            $('select#armycreator_unitstufftype_stuff')
                .val($('[data-fuzzysearch]:visible').val())
                .trigger('change');
        }

        var results = fuzzy.filter(filter, fuzzysearch);

        $('[data-fuzzysearch]').hide()
        var matches = results.map(function(el) {
            $('[data-fuzzysearch="' + el.string + '"]').show();
            return el.string;
        });

        $('select#armycreator_unitstufftype_stuff')
            .val($('[data-fuzzysearch]:visible').val())
            .trigger('change');
    });

    function quickCreate(type, value) {
        if (!value) {
            return;
        }
        var url = '/admin/' + armycreator.breed.game.code + '/' + armycreator.breed.slug + '/' + type + '/quick-create';

        $.ajax({
            type: 'post',
            url: url,
            data: { 'name': value }
        }).done(function (data) {
            $('#armycreator_unitstufftype_stuff')
                .append($('<option />').text(value).val(data.id))
                .val(data.id)
                .trigger('change');
        });
    }

    $('[data-create-quick-weapon]').on('click', function () { quickCreate('weapon', $('[data-fuzzyfilter]').val()); });
    $('[data-create-quick-equipement]').on('click', function () { quickCreate('equipement', $('[data-fuzzyfilter]').val()); });
});
