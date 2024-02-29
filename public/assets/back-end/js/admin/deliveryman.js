"use strict";

$(".js-example-responsive").select2({
    width: 'resolve'
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#viewer').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#customFileEg1").change(function () {
    readURL(this);
});

$(function () {
    let coba_image = $('#coba-image').data('url');
    let extension_error = $('#extension-error').data('text');
    let size_error = $('#size-error').data('text');
    $("#coba").spartanMultiImagePicker({
        fieldName: 'identity_image[]',
        maxCount: 5,
        rowHeight: '248px',
        groupClassName: 'col-6',
        maxFileSize: '',
        placeholderImage: {
            image: coba_image,
            width: '100%'
        },
        dropFileLabel: "Drop Here",
        onAddRow: function (index, file) {

        },
        onRenderedPreview: function (index) {

        },
        onRemoveRow: function (index) {

        },
        onExtensionErr: function (index, file) {
            toastr.error(extension_error, {
                CloseButton: true,
                ProgressBar: true
            });
        },
        onSizeErr: function (index, file) {
            toastr.error(size_error, {
                CloseButton: true,
                ProgressBar: true
            });
        }
    });
});

$('.deliveryman_status_form').on('submit', function (event){
    event.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        url:$(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function (data) {
            toastr.success($('#deliveryman-status-message').data('text'));
        }
    });
});

$('#from_date,#to_date').change(function () {
    let fr = $('#from_date').val();
    let to = $('#to_date').val();
    if(fr != ''){
        $('#to_date').attr('required','required');
    }
    if(to != ''){
        $('#from_date').attr('required','required');
    }
    if (fr != '' && to != '') {
        if (fr > to) {
            $('#from_date').val('');
            $('#to_date').val('');
            toastr.error('Invalid date range!', Error, {
                CloseButton: true,
                ProgressBar: true
            });
        }
    }

})

$("[class^=show-more-content]").hide();
$('.toggle_btn').on('click',function (){
    let show_more = "#show-more-" + $(this).attr('data-id')
    let show_less = "#show-less-" + $(this).attr('data-id')
    let show_more_content = "#show-more-content-" + $(this).attr('data-id')

    if($(show_more).is(":visible")){
        $(show_more_content).show(100);
        $(show_less).show(100);
        $(this).hide(100);
    }else if($(show_less).is(":visible")){
        $(show_more_content).hide(100);
        $(show_more).show(100);
        $(this).hide(100);
    }
})

$('.order-status-history').on('click', function (){
    let url = $('.status-history-url').data('url');
    let id = $(this).data('id');
    url = url.replace(":id", id)
    $.ajax({
        url: url,
        method: 'GET',
        success: function (data) {
            $(".load-with-ajax").empty().append(data);
        }
    });
});

$('#delivery_withdraw_status_filter').on('change', function() {
    let url = $(this).data('url');
    location.href=url+'?approved='+$(this).val();
});
