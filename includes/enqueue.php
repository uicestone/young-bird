<?php

add_action('wp', function() {

  wp_register_style('main', get_stylesheet_directory_uri() . '/css/main.css', array(), '1.0.0');
  wp_register_style('fontawesome', get_stylesheet_directory_uri() . '/css/fontawesome-all.min.css', array(), '5.0.13');
  wp_register_style('fontawesome.stars', get_stylesheet_directory_uri() . '/css/fontawesome-stars.css', array('fontawesome'), false);
  wp_register_style('fancybox', get_stylesheet_directory_uri() . '/css/jquery.fancybox.min.css', array(), '5.0.4');
  wp_register_style('carousel', get_stylesheet_directory_uri() . '/css/owl.carousel.min.css', array(), '2.2.0');
  wp_register_style('hshare', get_stylesheet_directory_uri() . '/css/hshare.min.css');
  wp_register_style('bootstrap-datepicker', get_stylesheet_directory_uri() . '/css/bootstrap-datepicker.min.css');
  wp_register_style('chosen', get_stylesheet_directory_uri() . '/css/chosen.css', array(), '1.0.0');
  wp_register_style('collect', get_stylesheet_directory_uri() . '/css/collect.css', array(), '1.0.0');
  wp_register_style('faq', get_stylesheet_directory_uri() . '/css/FAQ.css', array(), '1.0.0');
  wp_register_style('zz', get_stylesheet_directory_uri() . '/css/zz.css', array(), '1.0.0');
  wp_register_style('bootnavbar', get_stylesheet_directory_uri() . '/css/bootnavbar.css', array(), '1.0.0');
  wp_register_style('swiper', get_stylesheet_directory_uri() . '/css/swiper.css', array(), '1.0.0');
  wp_register_style('cases', get_stylesheet_directory_uri() . '/css/CASE.css', array(), '1.0.0');


  wp_register_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-3.2.1.slim.min.js', array(), '3.2.1', true);
  wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.0.0-beta.3', true);
  wp_register_script('bootstrap-datepicker', get_stylesheet_directory_uri() . '/js/bootstrap-datepicker.min.js', array('bootstrap'), '1.8.0', true);
  wp_register_script('bootstrap-datepicker.zh-CN', get_stylesheet_directory_uri() . '/js/bootstrap-datepicker.zh-CN.min.js', array('bootstrap-datepicker'), '1.8.0', true);
  wp_register_script('typeahead', get_stylesheet_directory_uri() . '/js/typeahead.bundle.min.js', array('jquery'), '0.11.1', true);
  wp_register_script('html.sortable', get_stylesheet_directory_uri() . '/js/html.sortable.min.js', array(), false, true);
  wp_register_script('fancybox', get_stylesheet_directory_uri() . '/js/jquery.fancybox.min.js', array(), false, true);
  wp_register_script('carousel', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', array(), false, true);
  wp_register_script('barrating', get_stylesheet_directory_uri() . '/js/jquery.barrating.min.js', array('jquery'), false, true);
  wp_register_script('popper', get_stylesheet_directory_uri() . '/js/popper.min.js', array('jquery'), false, true);
  wp_register_script('hshare', get_stylesheet_directory_uri() . '/js/hshare.min.js', array('jquery'), false, true);
  wp_register_script('fontawesome', get_stylesheet_directory_uri() . '/js/fontawesome-all.js', array(), '5.0.9', true);
  wp_register_script('wx', 'https://res.wx.qq.com/open/js/jweixin-1.2.0.js', array(), '1.2.0'.time(), true);
  wp_register_script('chosenbase', get_stylesheet_directory_uri() . '/js/chosen.jquery.min.js', array(), '1.7.0', true);
  wp_register_script('zoom', get_stylesheet_directory_uri() . '/js/zoom.js', array('jquery'), false, true);
  wp_register_script('swiper', get_stylesheet_directory_uri() . '/js/swiper.js', array('jquery'), false, true);
  wp_register_script('navdrop', get_stylesheet_directory_uri() . '/js/bootnavbar.js', array('jquery'), false, true);
  wp_register_script('main', get_stylesheet_directory_uri() . '/js/main.js', array('jquery', 'fancybox', 'html.sortable', 'barrating', 'carousel', 'hshare'), '1.0.0', true);
  wp_register_script('add_main', get_stylesheet_directory_uri() . '/js/add_main.js', array('jquery','zoom','swiper','navdrop'), '1.0.0', true);
  wp_register_script('location', 'https://4.url.cn/zc/chs/js/10062/location_' . (pll_current_language() === 'zh' ? 'chs' : 'en') . '.js', array('main'), false, true);

});

add_action('wp_enqueue_scripts', function(){
  wp_enqueue_style('fontawesome');
  wp_enqueue_style('fontawesome.stars');
  wp_enqueue_style('fancybox');
  wp_enqueue_style('carousel');
  wp_enqueue_style('hshare');
  wp_enqueue_style('bootstrap-datepicker');
  wp_enqueue_style('chosen');
  wp_enqueue_style('main');
  wp_enqueue_style('collect');
  wp_enqueue_style('faq');
  wp_enqueue_style('zz');
  wp_enqueue_style('swiper');
  wp_enqueue_style('bootnavbar');
  wp_enqueue_style('cases');


  
  wp_enqueue_script('typeahead');
  wp_enqueue_script('popper');
  wp_enqueue_script('bootstrap');
  wp_enqueue_script('bootstrap-datepicker');
  wp_enqueue_script('bootstrap-datepicker.zh-CN');
  if (strpos($_SERVER['HTTP_USER_AGENT'], ' SE 2.X ') !== false) {
    wp_enqueue_script('fontawesome');
  }
  wp_enqueue_script('hshare');
  if (class_exists('WeixinAPI') && WeixinAPI::in_wx()) {
    wp_enqueue_script('wx');
  }
  wp_enqueue_script('chosenbase');
  wp_enqueue_script('zoom');
  wp_enqueue_script('main');
  wp_enqueue_script('navdrop');
  wp_enqueue_script('swiper');
  wp_enqueue_script('add_main');
  wp_enqueue_script('location');
});
