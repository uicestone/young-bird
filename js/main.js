var YB = window.YB || {};

// Confirm 弹窗
YB.FancyConfirm = (function($) {
	function init(opts) {
		opts  = $.extend( true, {
	    title     : 'Are you sure?',
	    message   : '',
	    okButton  : '确认',
	    noButton  : '取消',
	    callback  : $.noop
	  }, opts || {} );
		$.fancybox.open({
	    type : 'html',
	    src  :
	    '<div class="fc-content">' +
	    '<h3>' + opts.title   + '</h3>' +
	    '<p>'  + opts.message + '</p>' +
	    '<div class="mt-5 d-flex justify-content-center">' +
	    '<a class="btn btn-secondary btn-common btn-lg bg-light-grey" data-value="0" data-fancybox-close>' + opts.noButton + '</a>' +
	    '<a class="btn btn-secondary btn-common btn-lg" data-value="1" data-fancybox-close>' + opts.okButton + '</a>' +
	    '</div>' +
	    '</div>',
	    opts : {
	      animationDuration : 350,
	      animationEffect   : 'material',
	      modal : true,
	      baseTpl :
	      '<div class="fancybox-container fc-container" role="dialog" tabindex="-1">' +
	      '<div class="fancybox-bg"></div>' +
	      '<div class="fancybox-inner">' +
	      '<div class="fancybox-stage"></div>' +
	      '</div>' +
	      '</div>',
	      afterClose : function( instance, current, e ) {
	        var button = e ? e.target || e.currentTarget : null;
	        var value  = button ? $(button).data('value') : 0;

	        opts.callback( value );
	      }
	    }
	  });
	}

  return {
		init: init
	}
})(jQuery);

// 报名
YB.Participate = (function($) {
	var form = $('.form-participate-position');

	function init() {
		bindEvent();
	}

	function bindEvent() {
		form.on('click', '.options .col', function() {
			var _this = $(this);
			YB.FancyConfirm.init({
				title     : "是否确认您的参赛身份，确认后将不能变更",
				callback  : function (value) {
					if (value) {
						_this.children('i').removeClass('fa-square').addClass('fa-check-square').parent()
							.siblings().children('i').removeClass('fa-check-square').addClass('fa-square');
					}
				}
			});
		})
		form.on('click', '.tab .col .btn', function() {
			if($(this).hasClass('bg-light-grey')) {
				var _index = $(this).parent().index();
				$(this).removeClass('bg-light-grey')
					.parent().siblings().children('.btn').addClass('bg-light-grey');
				console.log()
				form.find('.team').eq(_index).removeClass('d-none').siblings('.team').addClass('d-none');
			}
		})
	}

	return {
		init: init
	}
})(jQuery);



// 作品编辑
YB.Edit = (function($) {
	var container = $('.work-upload');

	function init() {
		console.log('123');
		sortable('.work-upload', {
			placeholderClass: 'col-lg-2-4 dashed'
		});
	}

	return {
		init: init
	}
})(jQuery);

// 评委评分
YB.Work = (function($){
	var list = $('.review-list');
	var pop = $('.fancypop');

	function init() {
		// 图片排序

    bindEvent();
	}

  function bindEvent() {
    list.on('click', '.item-review', function() {
      console.log($(this));
      // 填充数据

      // 入场
      $('.fancypop').show();

      // carousel
      // $('#carousel').carousel({
      //   interval: false
      // })
    })
  }

	return {
		init : init
	}
})(jQuery);
//
// YB.Work.init();
// YB.Edit.init();
YB.Participate.init();
