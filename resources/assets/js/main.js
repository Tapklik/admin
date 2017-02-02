$(function () {
    $('#_search-countries').select2({
        placeholder: 'Type a country'
    });

    $('*[data-plugin="datepicker"]').datepicker({
        format: 'yyyy-mm-dd'
    });
});