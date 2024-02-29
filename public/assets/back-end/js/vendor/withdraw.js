'use strict';
$('.status-filter').on('change',function (){
    let status = $(this).val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post({
        url: $('#get-status-filter-route').data('action'),
        data: {
            status: status
        },
        beforeSend: function () {
            $('#loading').fadeIn();
        },
        success: function (data) {
            $('#status-wise-view').html(data.view)
            $('#withdraw-requests-count').empty().html(data.count)
            closeRequest();
        },
        complete: function () {
            $('#loading').fadeOut();
        }
    });
})
function closeRequest(){
    $('.close-request').on('click',function (){
        let getText = $('#get-confirm-and-cancel-button-text');
        swal({
            title: getText.data('sure'),
            text: getText.data('delete-text'),
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            confirmButtonText: getText.data('confirm'),
        })
            .then((willDelete) => {
                if (willDelete.value) {
                    window.location.href = ($(this).data('action'));
                }
            });
    })
}
closeRequest();
