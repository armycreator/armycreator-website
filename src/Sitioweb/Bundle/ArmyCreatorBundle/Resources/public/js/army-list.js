var fuzzysearch;
$(function() {
    fuzzysearch = $('[data-fuzzysearch]').map(function () {
        return $(this).attr('data-fuzzysearch').trim();
    }).toArray();

    $('#armylist-filter').on('change, keydown', function () {
        var filter = $(this).val();

        if (!filter) {
            $('[data-fuzzysearch]').closest('tr').show()
        }
        var results = fuzzy.filter(filter, fuzzysearch);

        $('[data-fuzzysearch]').closest('tr').hide()
        var matches = results.map(function(el) {
            $('[data-fuzzysearch="' + el.string + '"]').closest('tr').show();
            return el.string;
        })
    });
});
