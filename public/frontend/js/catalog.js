$(document).ready(function(){
    /* Открыть/Закрыть меню каталога в aside*/
    $('.btn-open-menu').on('click',function () {
        $(this).parent('.main-li').toggleClass('open');
        $(this).parent('.main-li').find('.sub-menu').slideToggle();
    });

    /* Открыть/Закрыть под меню каталога в aside*/
    $('.btn-open-sub-menu').on('click',function () {
        $(this).parent('.sub-li').toggleClass('open');
        $(this).parent('.sub-li').find('.sub-child-menu').slideToggle();
    });

    /*Send form filters*/
    $('.filter-btn-success').on('click',function () {
        $('#form_filters_md').submit();
    });
});