/*Открыть форму поиска*/
function openFormSearch() {
    $('.search-box-div').find('.close-btn').removeClass('close');
    $('.search-box-div').slideDown();
    $('#search_input').focus();
}

/*Закрыть форму поиска*/
function closeFormSearch() {
    $('.search-box-div').find('.close-btn').addClass('close');
    $('.search-box-div').slideUp();
}

$(document).ready(function(){

    if ($(window).width() < 768) {
        $('.toggle-btn').siblings('.box').addClass('close');
    }

    $('.toggle-btn.phone').on('click',function (e) {
        e.preventDefault();
        $('.toggle-btn.user').siblings('.box').removeClass('open');
        $('.toggle-btn.user').siblings('.box').addClass('close');
        $(this).siblings('.box').toggleClass('open');
        $(this).siblings('.box').toggleClass('close');
    });
    $('.toggle-btn.user').on('click',function (e) {
        e.preventDefault();
        $('.toggle-btn.phone').siblings('.box').removeClass('open');
        $('.toggle-btn.phone').siblings('.box').addClass('close');
        $(this).siblings('.box').toggleClass('open');
        $(this).siblings('.box').toggleClass('close');
    });

    // fixed menu
    $(window).scroll(function () {
        if($(this).scrollTop()>40){
            $('.menu-top-box').css('position','fixed');
            $('.menu-top-box').css('top',0);
            $('.top-container').css('margin-top',80);
        }
        else{
            $('.menu-top-box').css('position','inherit');
            $('.top-container').css('margin-top',0);
        }
    });

    /*Открыть закрыть верхнее меню*/
    $('.hamburger-btn-menu').on('click',function () {
        $(this).toggleClass('is-active');
        $('.top-menu-box').toggleClass('mobile');
    });

    /*Открыть закрыть под меню*/
    $('.main-li.has-child').on('click',function () {
        $(this).toggleClass('open');
    });

});

/*Закрыть форму поиска по клавише escape*/
$(document).keyup(function(e){
    if(e.which == 27){
        closeFormSearch();
    }
});