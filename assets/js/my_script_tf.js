console.log("скрипт загружен 1");

jQuery(document).ready(function ($) {
    console.log("запущен tf");
//     //
    elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope) {
        console.log("element ready");

        var items = $('.pssa');
        // console.log(items);
        var z=0;
        for (var i of items) {
            // console.log(i.getAttribute('id'));
            // $(i).removeClass('slider');
            var clss = i.getAttribute('id').toString();
            // console.log(clss);
            $(i).addClass(clss);
            var data_pss =  JSON.parse(i.getAttribute('data-set-ss'));
            // console.log(i.getAttribute('data-set-ss'));
            console.log(data_pss);
            // console.log(++z);
            $('.'+clss).slick(data_pss);
        }

    });
});
