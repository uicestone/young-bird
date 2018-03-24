var YB = window.YB || {};

// Confirm 弹窗
YB.Util = (function($) {
	function preview(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$(input).next('img').attr('src', e.target.result).removeClass('d-none');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function confirm(opts) {
		opts  = $.extend( true, {
	    title     : 'Are you sure?',
	    message   : '',
	    okButton  : locale.ok,
	    noButton  : locale.cancel,
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

	function is_sm() {
		var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
		return width < 768
	}

  return {
		confirm: confirm,
		open: open,
		parseQueryString: parseQueryString,
		is_sm: is_sm,
		preview: preview
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
			var index = $(this).index();
			YB.Util.confirm({
				title     : locale.confirm_role,
				callback  : function (value) {
					if (value) {
						_this.children('i').removeClass('fa-square').addClass('fa-check-square').parent()
							.siblings().children('i').removeClass('fa-check-square').addClass('fa-square');
						//
						$('.check-'+index).removeClass('d-none').addClass('d-block');;
						$('.check-'+(1-index)).addClass('d-none').removeClass('d-block');
					}
				}
			});
		})
		form.on('click', '.tab .col .btn', function() {
			if($(this).hasClass('bg-light-grey')) {
				var _index = $(this).parent().index();
				$(this).removeClass('bg-light-grey')
					.parent().siblings().children('.btn').addClass('bg-light-grey');
				form.find('.team').eq(_index).removeClass('d-none').siblings('.team').addClass('d-none');
			}
		})

		// 活动报名（非竞赛）
		$('.attend-activity').on('click', function () {
			YB.Util.confirm({
        title     : locale.confirm_participate,
        callback  : function () {
					$.post(window.location.href, {attend:true}).done(function () {
						window.location.reload();
					}).fail(function (response) {
            if (response.status === 401) {
              window.location.href = window.location.protocol + '//' + window.location.host + '/sign-in/?intend=' + encodeURIComponent(window.location.href);
            }
          });
        }
      });
    });
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
	var eventList = $('.event-list');
	var workList = $('.toplist-container');
	var workDetail = $('.work-detail'),
			previewBox = $('.preview-box');
	var reviewList = $('.review-list');
	// var pop = $('.fancypop');

	function init() {
    bindEvent();
	}

	// 入围 / 不入围
	function update(id, status) {
		var reviewItem = $('#'+id);
		$.post(reviewItem.data('url'), {status:status}, function () {
      var result = status === 0 ? locale.reject : locale.pass;
      reviewItem.find('h3').text(result);
      close();
		});
	}

	function rate(id) {
		var reviewItem = $('#'+id);
		var score = $('#rateStar').val();
		var comment = $('.custom-rate-container textarea').val();

		$.post(reviewItem.data('url'), {score: score, comment: comment}, function () {
      var result = locale.score + score;
      reviewItem.find('h3').text(result);
      close();
    });
	}

	function close() {
		$.fancybox.close();
	}

	function showWork(el, hideCaption) {
		var box = el.next();
		var items = box.children();
		var avatar = box.data('judge-avatar');
		var name = box.data('judge-name');
		var comment = box.data('comment');
		var caption;
		if (name && comment) {
      caption = '<h3>'+locale.comment+'</h3><p>'+comment+'</p><p class="text-right">--'+name+'</p>';
		}
		if(hideCaption) {
			YB.Util.open(items)
		} else {
			YB.Util.open(items, caption)
		}
	}

  function bindEvent() {
		// 图片预览
		workDetail.find('.work-upload .custom-file-input').change(function() {
			var input = this;
			var _this = $(this);
			if (input.files && input.files[0]) {
		    var reader = new FileReader();
		    reader.onload = function(e) {
		      _this.next('img').attr('src', e.target.result).removeClass('d-none').next('.delete').removeClass('d-none');
		    }
		    reader.readAsDataURL(input.files[0]);
		  }
		})
		// 作品预览图预览
		workDetail.find('.poster.custom-file-container .custom-file-input').change(function() {
			YB.Util.preview(this);
		})
		// 删除图片
		$('.work-upload').on('click', '.delete', function(e) {
			e.preventDefault();
			$(this).addClass('d-none').prev('img').attr('src', '').addClass('d-none').prev('.custom-file-input').val('')
		})
		// 作品预览
		workDetail.on('click', '.btn-preview', function(e) {
			e.preventDefault();
			e.stopPropagation();
			// render data
			// title ?
			// desc
			var desc = workDetail.find('textarea').val();
			previewBox.find('.w-100 p').text(desc);
			// gallery
			// clean
			previewBox.children('a[class!="w-100"]').remove();
			workDetail.find('.work-upload .col-lg-2-4').each(function() {
				var src = $(this).find("img[class!='d-none']").attr('src');
				if(src) {
					previewBox.append('<a href="'+src+'">\
						<img src="'+src+'" />\
					</a>');
				}
			})
			showWork($(this), true);
		})
		// 查看作品详情
		workList.on('click', '.item-work', function() {
			showWork($(this))
		})
		eventList.on('click', '.item-work-anchor', function() {
			showWork($(this))
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
			var workUrl = $(this).data('url');

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
							<button type="button" class="btn btn-lg btn-secondary btn-block bg-cyan mt-3" onclick="YB.Work.rate(\''+id+'\')">'+locale.save+'</button>\
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
				caption = '<div class="row mb-4 tab"><div class="col"><button type="button" class="btn btn-lg btn-secondary btn-block" onclick="YB.Work.update(\''+id+'\', 1)">'+locale.pass+'</button></div><div class="col"><button type="button" class="btn btn-lg btn-secondary btn-block bg-light-grey" onclick="YB.Work.update(\''+id+'\', 0)">'+locale.reject+'</button></div></div>';
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
		$('.banner-home').owlCarousel({
			items: 1,
			nav: true,
			loop: true,
			margin: 10,
			autoplay: true
		});
		$('.related-news').owlCarousel({
			items: 4,
			nav: true,
			margin: 35,
			responsiveClass:true,
	    responsive:{
	        0:{
	            items:1
	        },
	        768:{
	            items:3,
	        },
	        992:{
	            items:4,
	        }
	    }
		});
	}

	return {
		init: init
	}
})(jQuery);

// 通用
YB.Common = (function($){
	function init() {
		var shareIconUrl = location.protocol + '//' + location.hostname + '/wp-content/themes/young-bird/images/share_icon.png';
		var desc = $('meta[name="description"]').attr('content');
		bindEvent();
		if (typeof wx !== 'undefined') {
			$.get('/wx-js-config/', function (data) {
				// data.debug = true;
				data.jsApiList = ['onMenuShareTimeline', 'onMenuShareAppMessage'];
				// alert(desc);
				wx.config(data);
				wx.ready(function () {
					wx.onMenuShareTimeline({
						title: '', // 分享标题
						link: '', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
						imgUrl: shareIconUrl, // 分享图标
						success: function () {
							// 用户确认分享后执行的回调函数
						},
						cancel: function () {
							// 用户取消分享后执行的回调函数
						}
					});
					wx.onMenuShareAppMessage({
						title: '', // 分享标题
						desc: desc, // 分享描述
						link: '', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
						imgUrl: shareIconUrl, // 分享图标
						type: 'link', // 分享类型,music、video或link，不填默认为link
						dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
						success: function () {
							// 用户确认分享后执行的回调函数
						},
						cancel: function () {
							// 用户取消分享后执行的回调函数
						}
					});
				});
			});
		}
	}

	function bindEvent() {
		// smooth hash
		$('a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
	        || location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name="' + this.hash.slice(1) +'"]');
         if (target.length) {
           $('html,body').animate({
             scrollTop: target.offset().top
          }, 500);
          return false;
        }
	    }
		});
	}

	return {
		init: init
	}
})(jQuery)

// 首页
YB.Home = (function($) {
	var newsListContainer = $('.list-news-container');
	var container = $('.home-news');
	var left = container.find('.column-left'),
			middle = container.find('.column-middle'),
			right = container.find('.column-right');
	var btn = container.find('.btn-loadmore');
	var page = 1;
	var totalPrimary = 2, totalSecondary = 2;
	var is_sm = YB.Util.is_sm();

	function init() {
		bindEvent();
	}

	function loadPrimary(fn) {
		if(page > totalPrimary) return
		$.ajax({
		  method: "GET",
		  url: btn.data('base-url-primary') + "page/"+page+"/?partial=true",
		})
		  .done(function( data, textStatus, jqXHR ) {
				totalPrimary = jqXHR.getResponseHeader('total-pages');
				var html = $.parseHTML(data);
				if(!is_sm) {
					middle.append(html);
				} else {
					newsListContainer.children().last().find('.column-middle').append(html);
				}
		  });
		fn && fn();
	}

	function loadSecondary(fn) {
		if(page > totalSecondary) return
		$.ajax({
		  method: "GET",
		  url: btn.data('base-url-secondary') + "page/"+page+"/?partial=true",
			dataType: "html",
		})
		  .done(function( data, textStatus, jqXHR ) {
				totalSecondary = jqXHR.getResponseHeader('total-pages');
				var html = $.parseHTML(data);
				var h = $(html).filter(function() {
				    return this.nodeType != 3;
				  });
				$(h).each(function(index) {
					if(index % 2 === 0) {
						if(!is_sm) {
							left.append($(this))
						} else {
							newsListContainer.children().last().find('.column-left').append(html);
						}
					}else{
						if(!is_sm) {
							right.append($(this))
						} else {
							newsListContainer.children().last().find('.column-right').append(html);
						}
					}
				});
				fn && fn();
		  });
	}

	function updateBtn() {
		if(page >= totalPrimary && page >= totalSecondary) {
			btn.removeClass('d-block').addClass('d-none');
		}
	}

	function generateTemplate() {
		return '<div class="list-news">\
		<div class="order-2 order-md-1 col-sm-8 col-md-3-11 column-left"></div>\
		<div class="order-1 order-md-2 col-sm-8 col-md-5-11 column-middle"></div>\
		<div class="order-3 order-md-3 col-sm-8 col-md-3-11 column-right"></div>\
		</div>';
	}

	function bindEvent() {
		container.on('click', '.btn-loadmore', function(e) {
			e.preventDefault();
			page++;
			if(is_sm) {
				// 手机版以8条数据为一个单元插入瀑布流
				var pageContainer = generateTemplate();
				newsListContainer.append($(pageContainer));
			}
			loadPrimary(updateBtn);
			loadSecondary(updateBtn);
		})
	}

	return {
		init: init
	}
})(jQuery)

// 瀑布流
YB.Pubu = (function($) {
	var container = $('.pubu');
	var list = container.find('.pubu-list');
	var btn = container.find('.btn-loadmore');
	var page = 1;
	var total = null;
	var ajaxUrl;

	function init() {
		bindEvent();
	}

	function updateBtn() {
		if(total && page >= total) {
			btn.removeClass('d-block').addClass('d-none');
		}
	}

	function loadMore(fn) {
		ajaxUrl = btn.data('base-url') + 'page/' + page + '/?partial=true&' + (location.search.replace(/^\?/, ''));
		if(total && page > total) return
		$.ajax({
		  method: "GET",
		  url: ajaxUrl
		})
		  .done(function( data, textStatus, jqXHR ) {
				total = jqXHR.getResponseHeader('total-pages');
				var html = $.parseHTML(data);
				list.append(html);
        fn && fn();
		  });
	}

	function bindEvent() {
		container.on('click', '.btn-loadmore', function(e) {
			e.preventDefault();
			page++;
			loadMore(updateBtn);
		})
	}

	return {
		init: init
	}
})(jQuery)

// 大咖
YB.Judge = (function($){
	var page = $('.judge-sign-in');

	function init() {
		// 检查删除按钮
		checkDelete('identities[]');
		checkDelete('institutions[]');
		checkDelete('awards[]');
		bindEvent();
	}

	function checkDelete(name) {
		var input = page.find('input[name="'+name+'"]')
		var parent = input.parents('.form-group')
		if(page.find('input[name="'+name+'"]').length === 1) {
			parent.find('.fa-trash-alt').addClass('d-none');
		} else {
			parent.find('.fa-trash-alt').removeClass('d-none');
		}
	}

	function bindEvent() {
		// 大咖中心图片预览
		page.find('.custom-file-container .custom-file-input').change(function() {
			YB.Util.preview(this);
		})
		// 文件名预览
		page.find('input[name="resume"]').change(function() {
			var input = this;
			var _this = $(this);
			if (input.files && input.files[0]) {
				_this.next('label').text(input.files[0].name);
			}
		})

		// 增加表单项
		page.on('click', '.form-group .fa-plus-circle', function(e) {
			e.preventDefault();
			var parent = $(this).parents('.form-group');
			var copy = parent.clone();
			var name = parent.find('input').eq(0).attr('name');
			$(copy).find('input').val('');
			$(copy).insertAfter(parent);
			checkDelete(name);
		})
		// 删除表单项
		page.on('click', '.form-group .fa-trash-alt', function(e) {
			e.preventDefault();
			var parent = $(this).parents('.form-group');
			var name = parent.find('input').eq(0).attr('name');
			// 如果只有一项则不能删除
			if(page.find('input[name="'+name+'"]').length > 1) {
				parent.remove();
			}
			checkDelete(name);
		})
	}

	return {
		init: init
	}
})(jQuery)

// 用户
YB.User = (function($){
	var page = $('.user-center-body');
	var mobileCodeContainer = $('.verify-code.login-is-mobile');
	var emailCodeContainer = $('.verify-code.login-is-email');
	function init() {
		bindEvent();
	}

	function isMobile(s) {
		return !isNaN(s) && s.length === 11;
	}

	function isEmail(s) {
		return !!s.match(/[^@]+@[^@]+/);
	}

	function bindEvent() {
		// 用户中心图片预览
		page.find('.custom-file-container .custom-file-input').change(function() {
			YB.Util.preview(this);
		})

		// 注册页验证码
		$('.sign-up [name="login"]').on('keyup change focus', function () {
			var login = $(this).val();
      $('.verify-code').hide()
        .find('[name="code"]').prop('disabled', true);
			if (isMobile($(this).val())) {
        mobileCodeContainer.show()
					.find('.send-verify-code').data('mobile', login).end()
					.find('[name="code"]').prop('disabled', false);
        emailCodeContainer
					.find('.send-verify-code').removeData('email');
      }
      else if (isEmail($(this).val())) {
        emailCodeContainer.show()
					.find('.send-verify-code').data('email', login).end()
          .find('[name="code"]').prop('disabled', false);
        mobileCodeContainer
          .find('.send-verify-code').removeData('mobile');
      }
    })

		$('.sign-up .send-verify-code').click(function () {
      var _this = $(this);
      var countdown = 60, interval;
      var urlPath = location.protocol + '//' + location.host + location.pathname;
      _this.text(locale.sent+'(' + countdown + ')s');
      // 开始倒计时
      _this.attr('disabled', true);
      interval = setInterval(function () {
        countdown--;
        _this.text(locale.sent+'(' + countdown + ')s');
        if(countdown === 0) {
          clearInterval(interval);
          _this.attr('disabled', false);
          _this.text(locale.resend);
        }
      }, 1000);
			if ($(this).data('mobile')) {
				$.get(urlPath + '?send_code_to_mobile=' + $(this).data('mobile'));
			} else if ($(this).data('email')) {
        $.get(urlPath + '?send_code_to_email=' + $(this).data('email'));
			}
		});
	}

	return {
		init: init
	}
})(jQuery)

// 竞赛
YB.Event = (function($){
  function init() {
    bindEvent();
  }

  function bindEvent() {
    $('.like').click(function (e) {
    	var self = this;
    	if ($(this).hasClass('far')) {
    		// 添加收藏/大众投票
    		$(this).removeClass('far').addClass('fas');
        $.post($(this).data('post-link') || window.location.href, {
    			like: true
        }).fail(function (response) {
					if (response.status === 401) {
						window.location.href = window.location.protocol + '//' + window.location.host + '/sign-in/?intend=' + encodeURIComponent(window.location.href);
					}
        }).done(function (likes) {
        	var likesContainer = $(self).next('.likes');
					if (likesContainer.length) {
						likesContainer.text(likes);
					}
        });
			}
			else {
    		// 取消收藏/大众投票
        $(this).removeClass('fas').addClass('far');
        $.post($(this).data('post-link') || window.location.href, {
          like: false
        }).fail(function (response) {
          if (response.status === 401) {
            window.location.href = window.location.protocol + '//' + window.location.host + '/sign-in/?intend=' + encodeURIComponent(window.location.href);
          }
        }).done(function (likes) {
          var likesContainer = $(self).next('.likes');
          if (likesContainer.length) {
            likesContainer.text(likes);
          }
        });
			}
			return false;
		});

    $('.remind-event-ending').click(function (event) {
    	event.preventDefault();
    	YB.Util.confirm({title: locale.remind_event_ending, callback: function () {
				$.post(window.location.href, {remind_event_ending: true});
			}});
		});
  }

  return {
    init: init
  }
})(jQuery)

// init
YB.Work.init();
YB.Edit.init();
YB.Participate.init();
YB.Carousel.init();
YB.Pubu.init();

//
YB.Common.init();
YB.Home.init();
YB.Judge.init();
YB.User.init();
YB.Event.init();
