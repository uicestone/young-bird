var YB = window.YB || {};

// Confirm 弹窗
YB.Util = (function($) {
	function confirm(opts) {
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

	function open(items, caption, cb) {
		$.fancybox.open( items, {
			idleTime  : false,
			baseClass : 'fancybox-custom-layout',
			margin    : 0,
			gutter    : 0,
			infobar   : false,
			thumbs    : {
				hideOnClose : false,
				parentEl    : '.fancybox-outer'
			},
			touch : {
				vertical : false
			},
			buttons : [
				'close',
				'thumbs',
				'fullScreen',
			],
			animationEffect   : "fade",
			animationDuration : 300,
			onInit : function( instance ) {
				instance.$refs.inner.wrap( '<div class="fancybox-outer"></div>' );
			},
			afterLoad: function() {
				cb && cb();
			},
			caption : function(instance, item) {
				return caption
			}
		});
	}

	function parseQueryString(query) {
	  var vars = query.split("&");
	  var query_string = {};
	  for (var i = 0; i < vars.length; i++) {
	    var pair = vars[i].split("=");
	    // If first entry with this name
	    if (typeof query_string[pair[0]] === "undefined") {
	      query_string[pair[0]] = decodeURIComponent(pair[1]);
	      // If second entry with this name
	    } else if (typeof query_string[pair[0]] === "string") {
	      var arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
	      query_string[pair[0]] = arr;
	      // If third or later entry with this name
	    } else {
	      query_string[pair[0]].push(decodeURIComponent(pair[1]));
	    }
	  }
	  return query_string;
	}

  return {
		confirm: confirm,
		open: open,
		parseQueryString: parseQueryString
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
			YB.Util.fancyConfirm({
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
		// 图片排序
		sortable('.work-upload', {
			placeholderClass: 'col-lg-2-4 dashed'
		});
	}

	return {
		init: init
	}
})(jQuery);

// 作品详情
YB.Work = (function($) {
	var workList = $('.toplist-container');
	var reviewList = $('.review-list');
	// var pop = $('.fancypop');

	function init() {
    bindEvent();
	}

	// 入围 / 不入围
	function update(id, status) {
		console.log(id);
		// ajax ...
		// callback
		var result = status === 0 ? '不入围' : '入围';
		$('#'+id).find('h3').text(result);
		close();
	}

	function rate(id) {
		// ajax ...
		// callback
		var result = '分数：' + $('#rateStar').val();
		$('#'+id).find('h3').text(result);
		close();
	}

	function close() {
		$.fancybox.close();
	}

  function bindEvent() {
		// 查看作品详情
		workList.on('click', '.item-work', function() {
			var box = $(this).next();
			var items = box.children();
			var avatar = box.data('judge-avatar');
			var name = box.data('judge-name');
			var comment = box.data('comment');
			var caption = '<h3>评论</h3><p>'+comment+'</p><p class="text-right">--'+name+'</p>';
			YB.Util.open(items, caption)
		})
		// 入围弹层
		reviewList.on('click', '.item-review', function() {
			var id = $(this).attr('id');
			var box = $(this).next();
			var items = box.children();
			var query = window.location.search.substring(1);
			var qs = YB.Util.parseQueryString(query);
			var caption;
			var onInit;
			if(qs && qs.stage === 'rating') {
				// 评分阶段
				caption = '\
					<div class="row mb-4 custom-rate-container">\
						<div class="col-16">\
							<textarea class="form-control" style="height:120px"></textarea>\
						</div>\
						<div class="col-8">\
							<select id="rateStar">\
								<option value="">0</option>\
								<option value="1">1</option>\
								<option value="2">2</option>\
								<option value="3">3</option>\
								<option value="4">4</option>\
								<option value="5">5</option>\
								<option value="6">6</option>\
								<option value="7">7</option>\
								<option value="8">8</option>\
								<option value="9">9</option>\
								<option value="10">10</option>\
							</select>\
							<button type="button" class="btn btn-lg btn-secondary btn-block bg-cyan mt-3" onclick="YB.Work.rate(\''+id+'\')">保存</button>\
						</div>\
					</div>';
				// init star rating
				onInit = function() {
					$('#rateStar').barrating({
						theme: 'fontawesome-stars',
						allowEmpty: true
					});
				}
			} else {
				// 入围评选
				caption = '<div class="row mb-4 tab"><div class="col"><button type="button" class="btn btn-lg btn-secondary btn-block" onclick="YB.Work.update(\''+id+'\', 1)">入围</button></div><div class="col"><button type="button" class="btn btn-lg btn-secondary btn-block bg-light-grey" onclick="YB.Work.update(\''+id+'\', 0)">不入围</button></div></div>';
			}
			YB.Util.open(items, caption, onInit)
		})
  }

	return {
		init : init,
		update: update,
		rate: rate
	}
})(jQuery);

// Carousel
YB.Carousel = (function($) {
	function init() {
		$('.owl-carousel').owlCarousel({
			items: 1,
			loop: true,
			margin: 10,
			autoplay: true
		});
	}

	return {
		init: init
	}
})(jQuery);


// init
YB.Work.init();
YB.Edit.init();
YB.Participate.init();
YB.Carousel.init();
