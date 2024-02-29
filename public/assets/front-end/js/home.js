"use strict";

updateFlashDealProgressBar();
setInterval(updateFlashDealProgressBar, 10000);

let directionFromSession = $('#direction-from-session').data('value');
$('.flash-deal-slider').owlCarousel({
    loop: false,
    autoplay: true,
    center:false,
    margin: 10,
    nav: true,
    navText: directionFromSession === 'rtl' ? ["<i class='czi-arrow-right'></i>", "<i class='czi-arrow-left'></i>"] : ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
    dots: false,
    autoplayHoverPause: true,
    rtl: directionFromSession === 'rtl',
    ltr: directionFromSession === 'ltr',
    responsive: {
        0: {
            items: 1.1
        },
        360: {
            items: 1.2
        },
        375: {
            items: 1.4
        },
        480: {
            items: 1.8
        },
        576: {
            items: 2
        },
        768: {
            items: 3
        },
        992: {
            items: 4
        },
        1200: {
            items: 4
        },
    },
})

$('.flash-deal-slider-mobile').owlCarousel({
    loop: false,
    autoplay: true,
    center:true,
    margin: 10,
    nav: true,
    navText: directionFromSession === 'rtl' ? ["<i class='czi-arrow-right'></i>", "<i class='czi-arrow-left'></i>"] : ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
    dots: false,
    autoplayHoverPause: true,
    rtl: directionFromSession === 'rtl',
    ltr: directionFromSession === 'ltr',
    responsive: {
        0: {
            items: 1.1
        },
        360: {
            items: 1.2
        },
        375: {
            items: 1.4
        },
        480: {
            items: 1.8
        },
        576: {
            items: 2
        },
        768: {
            items: 3
        },
        992: {
            items: 4
        },
        1200: {
            items: 4
        },
    },
})

$('#featured_products_list').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 20,
    nav: true,
    navText: directionFromSession === 'rtl' ? ["<i class='czi-arrow-right'></i>", "<i class='czi-arrow-left'></i>"] : ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
    dots: false,
    autoplayHoverPause: true,
    rtl: directionFromSession === 'rtl',
    ltr: directionFromSession === 'ltr',
    responsive: {
        0: {
            items: 1
        },
        360: {
            items: 1
        },
        375: {
            items: 1
        },
        540: {
            items: 2
        },
        576: {
            items: 2
        },
        768: {
            items: 3
        },
        992: {
            items: 4
        },
        1200: {
            items: 6
        },
    },
});

$('.new-arrivals-product').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 20,
    nav: true,
    navText: directionFromSession === 'rtl' ? ["<i class='czi-arrow-right'></i>", "<i class='czi-arrow-left'></i>"] : ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
    dots: false,
    autoplayHoverPause: true,
    rtl: directionFromSession === 'rtl',
    ltr: directionFromSession === 'ltr',
    responsive: {
        0: {
            items: 1.1
        },
        360: {
            items: 1.2
        },
        375: {
            items: 1.4
        },
        540: {
            items: 2
        },
        576: {
            items: 2
        },
        768: {
            items: 2
        },
        992: {
            items: 2
        },
        1200: {
            items: 4
        },
        1400: {
            items: 4
        }
    },
})

$('.category-wise-product-slider').owlCarousel({
    loop: true,
    autoplay: true,
    margin: 20,
    nav: true,
    navText: directionFromSession === 'rtl' ? ["<i class='czi-arrow-right'></i>", "<i class='czi-arrow-left'></i>"] : ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
    dots: false,
    autoplayHoverPause: true,
    rtl: directionFromSession === 'rtl',
    ltr: directionFromSession === 'ltr',
    responsive: {
        0: {
            items: 1.2
        },
        375: {
            items: 1.4
        },
        425: {
            items: 2
        },
        576: {
            items: 3
        },
        768: {
            items: 4
        },
        992: {
            items: 5
        },
        1200: {
            items: 6
        },
    },
})

$('.hero-slider').owlCarousel({
    loop: false,
    autoplay: true,
    margin: 20,
    nav: true,
    navText: directionFromSession === 'rtl' ? ["<i class='czi-arrow-right'></i>", "<i class='czi-arrow-left'></i>"] : ["<i class='czi-arrow-left'></i>", "<i class='czi-arrow-right'></i>"],
    dots: true,
    autoplayHoverPause: true,
    items: 1,
});

$('.brands-slider').owlCarousel({
    loop: false,
    autoplay: true,
    margin: 10,
    nav: false,
    rtl: directionFromSession === 'rtl',
    ltr: directionFromSession === 'ltr',
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 4,
            dots: true,
        },
        360: {
            items: 5,
            dots: true,
        },
        576: {
            items: 6,
            dots: false,
        },
        768: {
            items: 7,
            dots: false,
        },
        992: {
            items: 9,
            dots: false,
        },
        1200: {
            items: 11,
            dots: false,
        },
        1400: {
            items: 12,
            dots: false,
        }
    },
})

$('#category-slider, #top-seller-slider').owlCarousel({
    loop: false,
    autoplay: true,
    margin: 20,
    nav: false,
    dots: true,
    autoplayHoverPause: true,
    rtl: directionFromSession === 'rtl',
    ltr: directionFromSession === 'ltr',
    responsive: {
        0: {
            items: 2
        },
        360: {
            items: 3
        },
        375: {
            items: 3
        },
        540: {
            items: 4
        },
        576: {
            items: 5
        },
        768: {
            items: 6
        },
        992: {
            items: 8
        },
        1200: {
            items: 10
        },
        1400: {
            items: 11
        }
    },
})

$('.categories--slider').owlCarousel({
    loop: false,
    autoplay: true,
    margin: 20,
    nav: false,
    dots: false,
    autoplayHoverPause: true,
    rtl: directionFromSession === 'rtl',
    ltr: directionFromSession === 'ltr',
    responsive: {
        0: {
            items: 3
        },
        360: {
            items: 3.2
        },
        375: {
            items: 3.5
        },
        540: {
            items: 4
        },
        576: {
            items: 5
        },
        768: {
            items: 6
        },
        992: {
            items: 8
        },
        1200: {
            items: 10
        },
        1400: {
            items: 11
        }
    },
})

const othersStore = $(".others-store-slider").owlCarousel({
    responsiveClass: true,
    nav: false,
    dots: false,
    loop: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    smartSpeed: 600,
    rtl: directionFromSession === 'rtl',
    ltr: directionFromSession === 'ltr',
    responsive: {
        0: {
            items: 1.3,
            margin: 10,
        },
        480: {
            items: 2,
            margin: 26,
        },
        768: {
            items: 2,
            margin: 26,
        },
        992: {
            items: 3,
            margin: 26,
        },
        1200: {
            items: 4,
            margin: 26,
        },
    },
});

$(".store-next").on("click", function () {
    othersStore.trigger("next.owl.carousel", [600]);
});

$(".store-prev").on("click", function () {
    othersStore.trigger("prev.owl.carousel", [600]);
});
