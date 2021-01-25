console.log("скрипт загружен ");

jQuery(document).ready(function ($) {
    console.log("запущен");
    var items = $('.slider');
    for (var i of items) {
        console.log(i.getAttribute('id'));
        // $(i).removeClass('slider');
        var clss = i.getAttribute('id').toString();
        $(i).addClass(clss);
        $('.'+clss).slick({
            dots: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            speed: 500,
            easing: 'easy',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                }],
            // appendArrows: $(".content_arrow_slick"),


        });
    }
    // elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
    //     console.log("element ready ");
    //     console.log($scope);

    //
    // } );
});
