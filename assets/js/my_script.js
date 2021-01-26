// console.log("скрипт загружен 0");

jQuery(document).ready(function ($) {
    // console.log("запущен 0");
    var items = $('.pssa');
    // console.log(items);
    for (var i of items) {
        // console.log(i.getAttribute('id'));
        // $(i).removeClass('slider');
        var clss = i.getAttribute('id').toString();
        $(i).addClass(clss);
        var data_pss =  JSON.parse(i.getAttribute('data-set-ss'));
        // console.log(i.getAttribute('data-set-ss'));
        // console.log(data_pss);
        $('.'+clss).slick(data_pss);
    }
    // elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
    //     console.log("element ready ");
    //     console.log($scope);
    //
    //
    // } );
});
