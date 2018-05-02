$(document).ready(function(){
    /*Инициализация главного банера-слайдера*/
    $('.slider').slick({
        nextArrow: '.main-slider-btn-right',
        prevArrow: '.main-slider-btn-left',
        autoplay: true,
        autoplaySpeed: 3000,
        dots:true,
        dotsClass: 'slick-dots',
        infinite: true,
        speed: 1500,
    });

    /*Инициализация MIXITUPa*/
    var containerEl = document.querySelector('.container.mixitup');
    var mixer = mixitup(containerEl);
});