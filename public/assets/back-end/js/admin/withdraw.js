"use strict";

$("#status-filter").on('change', function () {
    let url = $('#status-filter-url').data('url');
    let type = $(this).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post({
        url: url,
        data: {
            status: type
        },
        beforeSend: function () {
            $('#loading').fadeIn();
        },
        success: function (data) {
            $('#statusWiseView').html(data.view)
            $('#withdrawRequestsCount').empty().html(data.count)
        },
        complete: function () {
            $('#loading').fadeOut();
        }
    });
});
