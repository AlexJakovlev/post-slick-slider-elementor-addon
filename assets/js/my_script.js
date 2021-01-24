console.log("скрипт загружен ");

jQuery(document).ready(function ($) {
    console.log("запущен");

    elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
        console.log("element ready");
        console.log($scope);
        $('.slider').slick({
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

    } );
});
