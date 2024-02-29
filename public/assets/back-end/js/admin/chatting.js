"use strict";

$(document).ready(function () {

    $("#myInput").on("keyup", function (e) {
        var value = $(this).val().toLowerCase();
        $(".list_filter").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //Chat Search Form
    $('#chat-search-form').on('submit', function (e) {
        e.preventDefault();
    });

    $('#myForm').on('submit', function (event) {
        event.preventDefault();
        var user_id = $('#hidden_value').val();
        let formData = new FormData(document.getElementById('myForm'));

        let post_url = $('#chatting-post-url').data('url');

        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
        });

        $.ajax({
            type: "POST",
            url: post_url,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#msgSendBtn").attr('disabled', true);
            },
            success: function (response) {
                let msg_history = $(".msg_history");
                let dateTime = new Date(response.time);
                let month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                let time = dateTime.toLocaleTimeString().toLowerCase();
                let date = month[dateTime.getMonth().toString()] + " " + dateTime.getDate().toString();

                let imageContainer = ''
                if (response.image.length !== 0) {
                    response.image.forEach(function (imageUrl, index) {
                        imageContainer += `
                        <div class="col-sm-3 col-md-2 position-relative img_row${index}">
                            <a data-lightbox="mygallery" href="${imageUrl}" class="aspect-1 overflow-hidden d-block border rounded">
                                <img src="${imageUrl}" alt="img" class="img-fit">
                            </a>
                        </div>`;
                    });
                }

                let message = response.message ? `<div class="d-flex justify-content-end">
                                        <p class="bg-c1 text-white rounded px-3 py-2 mb-1"">${response.message}</p>
                                    </div>` : '';

                msg_history.prepend(`
                    <div class="outgoing_msg" id="outgoing_msg">
                        <div class='sent_msg'>
                        ${message}
                        <div class="row g-2 flex-wrap pt-1 justify-content-end">
                            ${imageContainer}
                        </div>
                        <span class='time_date fz-12 pt-2 d-flex justify-content-end'> now </span>
                        </div>
                    </div>
                `)
                $(this).trigger('reset');

                msg_history.stop().animate({scrollTop: msg_history[0].scrollHeight}, 1000);
                $('.filearray').empty().html('');
                $('#selected-files-container').empty().html('');
                $('#msgInputValue').val('');
                $('#msgfilesValue').val('');
                selectedFiles = [];
            },
            complete: function () {
                $("#msgSendBtn").removeAttr('disabled', true);
            },
            error: function (error) {
                let errorData = JSON.parse(error.responseText);
                toastr.warning(errorData.message);
            }
        });

    });
});

let selectedFiles = [];
$(document).on('ready', () => {
    $("#msgfilesValue").on('change', function () {
        for (let i = 0; i < this.files.length; ++i) {
            selectedFiles.push(this.files[i]);
        }
        // Display the selected files
        displaySelectedFiles();
    });

    function displaySelectedFiles() {
        /*start*/
        const container = document.getElementById("selected-files-container");
        container.innerHTML = ""; // Clear previous content
        selectedFiles.forEach((file, index) => {
            const input = document.createElement("input");
            input.type = "file";
            input.name = `image[${index}]`;
            input.classList.add(`image_index${index}`);
            input.hidden = true;
            container.appendChild(input);
            /*BlobPropertyBag :
            / This type represents a collection of object properties and does not have an
            / explicit JavaScript representation.
            */
            const blob = new Blob([file], {type: file.type});
            const file_obj = new File([file], file.name);
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file_obj);
            input.files = dataTransfer.files;
        });
        /*end */
        $(".filearray").empty(); // Clear previous user input
        for (let i = 0; i < selectedFiles.length; ++i) {
            let filereader = new FileReader();
            let $uploadDiv = jQuery.parseHTML("<div class='upload_img_box'><span class='img-clear'><i class='tio-clear'></i></span><img src='' alt=''></div>");

            filereader.onload = function () {
                // Set the src attribute of the img tag within the created div
                $($uploadDiv).find('img').attr('src', this.result);
                let imageData = this.result;
            };

            filereader.readAsDataURL(selectedFiles[i]);
            $(".filearray").append($uploadDiv);
            // Attach a click event handler to the "tio-clear" icon to remove the associated div and file from the array
            $($uploadDiv).find('.img-clear').on('click', function () {
                $(this).closest('.upload_img_box').remove();

                selectedFiles.splice(i, 1);
                $('.image_index' + i).remove();
            });
        }
    }
});

$(".messageView").on('click', function () {
    let user_id = $(this).data('user_id');
    let user_gen_id = '.user_' + user_id;
    let customer_name = $(user_gen_id).data('name');
    let customer_phone = $(user_gen_id).data('phone');
    let customer_image = $(user_gen_id).data('image');

    $('#profile_name').text(customer_name)
    $('#profile_phone').text(customer_phone)
    $('#profile_image').attr("src", customer_image)

    //active when click on seller
    $('.chat_list.active').removeClass('active');
    $(`.user_${user_id}`).addClass("active");
    $('.seller').css('color', 'black');
    $(`.user_${user_id} h5`).css('color', '#377dff');

    let url = $('#deliveryman-get-url').data('url')+"?delivery_man_id=" + user_id;
    $.ajax({
        type: "get",
        url: url,

        success: function (data) {
            $('.msg_history').html('');
            $('.chat_ib').find('#' + user_id).removeClass('active-text');
            if (data.length != 0) {
                data.map((element, index) => {
                    let dateTime = new Date(element.created_at);
                    let month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                    let time = dateTime.toLocaleTimeString().toLowerCase();
                    let date = month[dateTime.getMonth().toString()] + " " + dateTime.getDate().toString();

                    let attachment_files = element.attachment;
                    let imageContainer = '';
                    if (attachment_files != null) {
                        JSON.parse(attachment_files).map((imageUrl, index) => {
                            imageContainer += `
                                <div class="col-sm-3 col-md-2 position-relative img_row${index}">
                                    <a data-lightbox="mygallery" href="${imageUrl}" class="aspect-1 overflow-hidden d-block border rounded">
                                        <img src="${imageUrl}" alt="img" class="img-fit">
                                    </a>
                                </div>`;
                        });
                    }
                    if (element.sent_by_admin) {
                        let adminMessage = element.message ? `<div class='d-flex justify-content-end'>
                          <p class="bg-c1 text-white rounded px-3 py-2">${element.message}</p>
                        </div>` : '';
                        $(".msg_history").prepend(`
                          <div class="outgoing_msg" id="outgoing_msg">
                            <div class='sent_msg'>
                            ${adminMessage}
                            <div class="row g-2 flex-wrap pt-1 justify-content-end">
                                ${imageContainer}
                            </div>
                              <span class='time_date fz-12 pt-2 d-flex justify-content-end'> ${time}    |    ${date}</span>
                            </div>
                          </div>`
                        )

                    } else {
                        let receiveMessage =element.message ? `<div class='d-flex justify-content-start'>
                                    <p class="bg-chat rounded px-3 py-2 mb-1" id="receive_msg">${element.message}</p>
                                </div>` : '';
                        $(".msg_history").prepend(`
                          <div class="incoming_msg" id="incoming_msg">
                            <div class="incoming_msg_img" id="">
                              <img src="${window.location.origin}/storage/app/public/profile/${element.image}" class="__rounded-10" alt="">
                            </div>
                            <div class="received_msg">
                              <div class="received_withdraw_msg">
                              ${receiveMessage}
                                <div class="row g-2 flex-wrap pt-1 justify-content-start">
                                    ${imageContainer}
                                </div>
                              <span class="time_date fz-12"> ${time}    |    ${date}</span></div>
                            </div>
                          </div>`
                        )
                    }

                    $('#hidden_value').attr("value", user_id);
                    $('#notif-alert-' + user_id).hide();
                })
            } else {
                $(".msg_history").html(`<p> {{translate('no_message_available')}} </p>`);
                data = [];
            }

        }
    });

    $('.type_msg').css('display', 'block');
});

$('.onClick').on('click', function () {
    alert((this).data('text'));
});
