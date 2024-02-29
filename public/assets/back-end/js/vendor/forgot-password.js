"use strict";

$(document).on('ready', function () {
    // INITIALIZATION OF SHOW PASSWORD
    // =======================================================
    $('.js-toggle-password').each(function () {
        new HSTogglePassword(this).init()
    });

    // INITIALIZATION OF FORM VALIDATION
    // =======================================================
    $('.js-validate').each(function () {
        $.HSCore.components.HSValidation.init($(this));
    });
});

var backgroundImage = $("[data-bg-img]");
backgroundImage.css("background-image", function () {
    return 'url("' + $(this).data("bg-img") + '")';
}).removeAttr("data-bg-img").addClass("bg-img");

$('.onerror-logo').on('error', function () {
    let image = $('#onerror-logo').data('onerror-logo');
    $(this).attr('src', image);
});
