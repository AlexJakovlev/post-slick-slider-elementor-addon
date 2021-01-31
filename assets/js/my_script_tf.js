console.log("скрипт загружен tf");

jQuery(document).ready(function ($) {
    console.log("запущен tf");

    elementorFrontend.hooks.addAction('frontend/element_ready/widget', function (scope) {
        console.log("element ready");
        var items = $('.pssa');
        for (var i of items) {
            // console.log(i);
            var clss = i.getAttribute('data-id').toString();
            if ($(i).hasClass(clss)) {
                $('.' + clss).slick('unslick');
            }
            $(i).addClass(clss);
            data_pss = JSON.parse(i.getAttribute('data-set-ss'));
            console.log('создаем слайдер -- ', clss);
            $('.' + clss).slick(data_pss);
        }
    });
});
