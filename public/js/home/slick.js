$(document).ready(function(){
    //Inicio de slick - carrusel de fotos
    $('.slider-content').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        autoplay: true,
        autoplaySpeed: 5000,
        asNavFor: '.slider-nav',
        mobileFirst: true
    });
    $('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-content',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        vertical: false,
        mobileFirst: false
    });
    //fin de slick - carrusel de fotos
});