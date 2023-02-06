$(document).ready(function(){
    var owl = $('.owl-carousel-slider');
    owl.owlCarousel({
        loop: true,
        margin: 10,
        center:true,
        autoplay: true,
        nav: false,
        navigation: true,
        autoplayTimeout: 5000,
        dots: false,
        autoWidth:true,
        items:1,
    });


    $('.owl-carousel-product').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: false,
        nav: false,
        navigation: false,
        autoplayTimeout: 5000,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });
});