var YB = window.YB || {};
var YB_SOURCE_PATH = location.protocol + '//' + location.host + '/wp-content/themes/young-bird/';

//添加第二部来源收集
YB.NewStep = (function ($) {
    function init() {
        ChangeRaid();
    }
    function ChangeRaid(){
        $(".page-collect .form-check-label[for='other']").click(function () {
            //   $(".page-collect .dropdown>a").removeClass('has_checked');
              var ChangeShow = $(this).siblings(".form-check-input");
              if (ChangeShow.is(":checked")) {
                // ChangeShow.attr("checked",false);
                // console.log(ChangeShow.val());
                $(".ybp_other").removeClass("has_other");
              }
              else {
                // ChangeShow.attr("checked",true);
                console.log("not"+ChangeShow.val());
                $(".ybp_other").addClass("has_other");
                
              }
          })
          $(".page-collect .dropdown-item .form-check-label").click(function(){
            var getText = $(this).text();
            console.log(getText);
            var txt="<div class='selected_item' data-from="+getText+"><h5>"+getText+"</h5></div>";
            var CreatItem =$(this).siblings(".form-check-input");
            if(CreatItem.is(":checked")){
                console.log("这里是:"+getText);
                $(this).parents(".dropdown").find(".selected_item[data-from="+getText+"]").remove();
            }
            else{
                console.log("yes");
                $(this).parents(".dropdown").find("a").after(txt);
            }
        })
        $(".page-collect form").submit(function(e){
            if($("#other").is(":checked")){
                console.log("break");
                var YesVal = $("input[name='ybp_other']").val()
                if(YesVal){
                    // alert("Submit seccess");
                }
                else{
                    $("input[name='ybp_other']").addClass("collect_need")
                    // console.log("breaked");
                    // alert("Submit no");
                    e.preventDefault();
                }
            }
            else{
                // alert("Submit prevented");
            }
        });
        //   $(".page-collect .dropdown .form-check-label").click(function () {
        //       var item = $(this).text();
        //       $(this).prev('input').attr('checked', true);
        //     //   console.log(item);
        //       $(this).parents('.dropdown').find('a').html(item);
        //       $(this).parents('.dropdown').find('a').addClass('has_checked');
        //   })
      }
    return {
        init: init
    }
})(jQuery);

YB.zoomIn =(function ($){
    function init() {
        startZoom();
    }
    function startZoom(){
        var obj = new zoom('mask', 'bigimg','smallimg');
        obj.init();
    }
    return {
        init: init
    }
})(jQuery);

YB.SwiperContral=(function($){
    function init() {
        SwiperZoom()
    }
    function SwiperZoom(){
        // case
        var galleryCaseSwiper = new Swiper('.cases_index_swiper .cases_swiper', {
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
            },

            // 如果需要前进后退按钮
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        })

        // case_detail
        var phone = 767;
        var WinWidth = $(window).width();
        if (WinWidth > phone) {
            var thumbsSwiper = new Swiper('.cases_thumbs', {
                spaceBetween: 20,
                slidesPerView: 5,
                watchSlidesVisibility: true,//防止不可点击
            })
            var gallerySwiper = new Swiper('.cases_swiper', {
                spaceBetween: 10,
                pagination: {
                    el: '.swiper-pagination',
                },

                // 如果需要前进后退按钮
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                thumbs: {
                    swiper: thumbsSwiper,
                }
            })
        }
        else {
            var thumbsSwiper = new Swiper('.cases_thumbs', {
                spaceBetween: 10,
                slidesPerView: 4,
                watchSlidesVisibility: true,//防止不可点击

            })
            var gallerySwiper = new Swiper('.cases_swiper', {
                spaceBetween: 10,
                pagination: {
                    el: '.swiper-pagination',
                },

                // 如果需要前进后退按钮
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                thumbs: {
                    swiper: thumbsSwiper,
                }
            })
        }
    }
    return {
        init: init
    }
})(jQuery)
// 二级下拉
YB.NavDropdown=(function($){
    function init(){
        NewNavDrop();
    }
    function NewNavDrop(){
        $("body").on('click', '[data-stopPropagation]', function (e) {
            e.stopPropagation();
        });
        $('.select_nav').bootnavbar();
    }
    return{
        init:init
    }
})(jQuery);

// tooltip
YB.Tooltip=(function($){
    function init(){
        NewTip();
    }
    function NewTip(){
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
          })
    }
    return{
        init:init
    }
})(jQuery);

//必填修改
YB.ChangeRequired=(function($){
    function init(){
        SetRequired();
    }
    function SetRequired(){
        $(window).load(
            function(){
                if($("body").hasClass("lang-en")){
                    $("input[name='email']").prop("required", true);;
                    $("input[name='mobile']").prop("required", false);;
                }
                else if($("body").hasClass("lang-zh")){
                    $("input[name='email']").prop("required", false);
                    $("input[name='mobile']").prop("required", true);
                }
                else{
    
                }
            }
        )
        
    }
    return{
        init:init
    }
})(jQuery);

// readmore
YB.ChangeRead=(function($){
    function init(){
        ReadMore();
    }
    function ReadMore(){
        var cr =$(".case_list .read_more");
        var sr =$(".story_list .read_more");
        var isFirst = new Boolean(true);
        var isFirst2 = new Boolean(true);
        cr.click(function(){
            if(cr.hasClass("collapsed")){
                $(this).html("收起");
            }
            else{
                $(this).html("更多");
            }
            if(isFirst){
                console.log(1);
                cr.html("收起");
                isFirst = false;
            }
        })
        sr.click(function(){
            if(sr.hasClass("collapsed")){
                $(this).html("收起");
            }
            else{
                $(this).html("更多");
            }
            if(isFirst2){
                console.log(2);
                sr.html("收起");
                isFirst2 = false;
            }
        })
        
    }
    return{
        init:init
    }
})(jQuery);

YB.NewStep.init();
YB.zoomIn.init();
YB.SwiperContral.init();
YB.NavDropdown.init();
YB.ChangeRead.init();
YB.Tooltip.init();
YB.ChangeRequired.init();