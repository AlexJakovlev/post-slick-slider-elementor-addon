console.log("скрипт загружен 0");

jQuery(document).on('ready',function () {
    console.log("element ready");
    var items = jQuery('.pssa');
    for (var i of items) {
        // console.log(i);
        var clss = i.getAttribute('data-id').toString();
        if (jQuery(i).hasClass(clss)) {
            jQuery('.' + clss).slick('unslick');
        }
        jQuery(i).addClass(clss);
        data_pss = JSON.parse(i.getAttribute('data-set-ss'));
        console.log('создаем слайдер -- ', clss);
        jQuery('.' + clss).slick(data_pss);
    }
});
