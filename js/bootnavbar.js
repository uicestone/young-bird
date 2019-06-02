(function($) {
    var pc = 1279;
    var WinWidth = $(window).width();

    $.fn.bootnavbar = function () {
        if (WinWidth < pc == true) {

            // $(this).find("a").hover(function () {
            //     // $(this).addClass('show');
            //     $(this).next('.dropdown-menu').addClass('show');
            //     // $(this).find(".dropdown-menu").addClass('show');
            // },function(){
            //     $(this).removeClass('show');
            //     $(this).next('.dropdown-menu').removeClass('show');
            //     $(this).find('.dropdown-menu').first().removeClass('show');
            // })
        }
        //else{
            $(this).find('.dropdown').hover(function () {
                $(this).addClass('show');
                $(this).find('.dropdown-menu').first().addClass('show').addClass('animated fadeIn').one('animationend oAnimationEnd mozAnimationEnd webkitAnimationEnd', function () {
                    $(this).removeClass('animated fadeIn');
                });
            }, function () {
                $(this).removeClass('show');
                $(this).find('.dropdown-menu').first().removeClass('show');
            });
        //}
        
    }; 
   
})(jQuery);