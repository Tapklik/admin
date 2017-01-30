$(function () {
    $('#_search-countries').select2({
        placeholder: 'Type a country'
    });

    $('#_search-countries').on('select2:select', function (evt) {

        $.ajax({
            url: '/data/countries/' + $('#_search-countries').val(),
            success: function (response) {

                html = '';
                $.each(response[0].cities, function () {
                    var item = this;
                    html += '<option value="' + item.id + '">' + item.name + '</option>';
                });

                $('#_search-cities').html(html);
                $('#_search-cities').select2({
                    placeholder: 'Type a country'
                });
            }
        });
    });

    $('#_search-cities').on('select2:select', function (evt) {

        $.ajax({
            url: '/data/countries/' + $('#_search-countries').val() + '/' + $('#_search-cities').val(),
            success: function (response) {

                $('#_geo_data').html('<div class="row">{' + response.city + ', ' + response.country + ', ' + response.region + ', ' + response.region_name + '}</div>');
            }
        })
    });
});