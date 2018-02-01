var YB = window.YB || {};

// 作品编辑
YB.Edit = (function() {
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
})();

// 评委评分
YB.Work = (function(){
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
})();

YB.Work.init();
YB.Edit.init();
