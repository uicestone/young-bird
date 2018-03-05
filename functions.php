<?php

require __DIR__ . '/includes/cmb2.functions.php';
require __DIR__ . '/includes/aliyun.signature_helper.php';

remove_filter('template_redirect','redirect_canonical');

show_admin_bar(false);

add_action('after_setup_theme', function () {
  foreach (array(
    'Judge Center', 'Judge Sign Up', 'Forget Password', 'Reset Password', 'Sign In', 'Sign Up', 'User Center'
  ) as $name) {
    init_page_placeholder($name);
  }

  add_role('judge', __('大咖', 'young-bird'), array());
  add_role('attendee', __('选手', 'young-bird'), array());
  remove_role('subscriber'); remove_role('author'); remove_role('contributor');

  $judge_role = get_role('judge'); $judge_role->add_cap('judge_works');

  add_image_size('1-2', 350, 700, true);
  add_image_size('medium-sq', 300, 300, true);
  add_image_size('8-7', 320, 280, true);
  add_image_size('5-4', 500, 400, true);
  add_image_size('5-3', 1000, 600, true);
  add_image_size('vga', 640, 480, true);
  add_image_size('3-2', 600, 400, true);
  add_image_size('hd', 1280, 720, true);
  add_image_size('movie', 1920, 800, true);
  add_image_size('5-1', 1920, 384, true);

  load_theme_textdomain('young-bird', get_template_directory() . '/languages');
});

function init_page_placeholder ($name) {
  if (!get_page_by_path(sanitize_title($name))) {
    wp_insert_post(array(
      'post_title' => $name,
      'post_type' => 'page',
      'post_status' => 'publish',
      'post_content' => 'This is a placeholder required by system, please DO NOT REMOVE it.'
    ));
  }
}

add_action( 'admin_notices', function () {
  if( ! function_exists('get_fields') )
    echo '<div class="error"><p>' . __( '需要激活 Advanced Custom Fields 插件' ) . '</p></div>';

  if ( ! function_exists('new_cmb2_box'))
    echo '<div class="error"><p>' . __( '需要激活 CMB2 插件' ) . '</p></div>';
} );

add_action('admin_menu', function () {
  remove_menu_page( 'edit-comments' );
});

add_theme_support('post-thumbnails');

add_action('init', function () {

  register_taxonomy('event_category', 'event', array (
    'label' => __('竞赛分类', 'young-bird'),
    'labels' => array(
      'all_items' => __('所有竞赛分类', 'young-bird'),
      'add_new' => __('添加竞赛分类', 'young-bird'),
      'add_new_item' => __('新竞赛分类', 'young-bird'),
    ),
    'public' => true,
    'show_admin_column' => true,
    'hierarchical' => true
  ));

  register_taxonomy('news_category', 'post', array (
    'label' => __('资讯分类', 'young-bird'),
    'labels' => array(
      'all_items' => __('所有资讯分类', 'young-bird'),
      'add_new' => __('添加资讯分类', 'young-bird'),
      'add_new_item' => __('新资讯分类', 'young-bird'),
    ),
    'public' => true,
    'show_admin_column' => true,
    'hierarchical' => true
  ));

  register_taxonomy('ad_category', 'post', array (
    'label' => __('广告分类', 'young-bird'),
    'labels' => array(
      'all_items' => __('所有广告分类', 'young-bird'),
      'add_new' => __('添加广告分类', 'young-bird'),
      'add_new_item' => __('新广告分类', 'young-bird'),
    ),
    'public' => true,
    'show_admin_column' => true,
    'hierarchical' => true
  ));

  register_post_type('event', array(
    'label' => __('竞赛', 'young-bird'),
    'labels' => array(
      'all_items' => __('所有竞赛', 'young-bird'),
      'add_new' => __('添加竞赛', 'young-bird'),
      'add_new_item' => __('新竞赛', 'young-bird'),
      'edit_item' => __('编辑竞赛', 'young-bird'),
      'not_found' => '未找到竞赛'
    ),
    'public' => true,
    'supports' => array('title', 'subtitles', 'excerpt', 'editor', 'thumbnail', 'revisions'),
    'taxonomies' => array('post_tag', 'category'),
    'menu_icon' => 'dashicons-admin-customizer',
    'has_archive' => true
  ));

  register_post_type('rank', array(
    'label' => __('轮次', 'young-bird'),
    'labels' => array(
      'all_items' => __('所有轮次', 'young-bird'),
      'add_new' => __('添加轮次', 'young-bird'),
      'add_new_item' => __('新轮次', 'young-bird'),
      'edit_item' => __('编辑轮次', 'young-bird'),
      'not_found' => __('未找到轮次', 'young-bird')
    ),
    'public' => true,
    'supports' => array('title'),
    'taxonomies' => array('post_tag'),
    'menu_icon' => 'dashicons-thumbs-up ',
    'has_archive' => true
  ));

  register_post_type('group', array(
    'label' => __('团队', 'young-bird'),
    'labels' => array(
      'all_items' => __('所有团队', 'young-bird'),
      'add_new' => __('添加团队', 'young-bird'),
      'add_new_item' => __('新团队', 'young-bird'),
      'edit_item' => __('编辑团队', 'young-bird'),
      'not_found' => __('未找到团队', 'young-bird')
    ),
    'public' => true,
    'supports' => array('title', 'excerpt', 'thumbnail', 'author'),
    'taxonomies' => array('post_tag'),
    'menu_icon' => 'dashicons-groups',
    'has_archive' => true
  ));

  register_post_type('work', array(
    'label' => __('作品', 'young-bird'),
    'labels' => array(
      'all_items' => __('所有作品', 'young-bird'),
      'add_new' => __('添加作品', 'young-bird'),
      'add_new_item' => __('新作品', 'young-bird'),
      'edit_item' => __('编辑作品', 'young-bird'),
      'not_found' => __('未找到作品', 'young-bird')
    ),
    'public' => true,
    'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'author'),
    'taxonomies' => array('post_tag'),
    'menu_icon' => 'dashicons-admin-customizer',
    'has_archive' => true
  ));

  register_post_type('judge', array(
    'label' => __('大咖', 'young-bird'),
    'labels' => array(
      'all_items' => __('所有大咖', 'young-bird'),
      'add_new' => __('添加大咖', 'young-bird'),
      'add_new_item' => __('新大咖', 'young-bird'),
      'edit_item' => __('编辑大咖', 'young-bird'),
      'not_found' => __('未找到大咖', 'young-bird')
    ),
    'public' => true,
    'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'revisions'),
    'taxonomies' => array('post_tag'),
    'menu_icon' => 'dashicons-welcome-learn-more',
    'has_archive' => true
  ));

  register_post_type('message', array(
    'label' => __('消息', 'young-bird'),
    'labels' => array(
      'all_items' => __('所有消息', 'young-bird'),
      'add_new' => __('添加消息', 'young-bird'),
      'add_new_item' => __('新消息', 'young-bird'),
      'edit_item' => __('编辑消息', 'young-bird'),
      'not_found' => __('未找到消息', 'young-bird')
    ),
    'public' => true,
    'supports' => array('title', 'editor', 'author'),
    'menu_icon' => 'dashicons-email',
    'has_archive' => true
  ));
});

add_action('wp', function() {

  wp_register_style('main', get_stylesheet_directory_uri() . '/css/main.css', array(), '1.0.0');
  wp_register_style('fontawesome', get_stylesheet_directory_uri() . '/css/fontawesome.css', array(), '5.0.4');
  wp_register_style('fontawesome.stars', get_stylesheet_directory_uri() . '/css/fontawesome-stars.css', array('fontawesome'), '5.0.4');
  wp_register_style('fancybox', get_stylesheet_directory_uri() . '/css/jquery.fancybox.min.css', array(), '5.0.4');
  wp_register_style('carousel', get_stylesheet_directory_uri() . '/css/owl.carousel.min.css', array(), '2.2.0');

  wp_register_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-3.2.1.slim.min.js', array(), '3.2.1', true);
  wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.0.0-beta.3', true);
  wp_register_script('html.sortable', get_stylesheet_directory_uri() . '/js/html.sortable.min.js', array(), false, true);
  wp_register_script('fancybox', get_stylesheet_directory_uri() . '/js/jquery.fancybox.min.js', array(), false, true);
  wp_register_script('carousel', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', array(), false, true);
  wp_register_script('barrating', get_stylesheet_directory_uri() . '/js/jquery.barrating.min.js', array('jquery'), false, true);
  wp_register_script('popper', get_stylesheet_directory_uri() . '/js/popper.min.js', array('jquery'), false, true);
  wp_register_script('main', get_stylesheet_directory_uri() . '/js/main.js', array('jquery', 'fancybox', 'html.sortable', 'barrating', 'carousel'), '1.0.0', true);
});

add_action('wp_enqueue_scripts', function(){
  wp_enqueue_style('main');
  wp_enqueue_style('fontawesome');
  wp_enqueue_style('fontawesome.stars');
  wp_enqueue_style('fancybox');
  wp_enqueue_style('carousel');

  wp_enqueue_script('bootstrap');
  wp_enqueue_script('popper');
  wp_enqueue_script('main');
});

add_filter ('sanitize_user', function ($username, $raw_username, $strict) {
  $username = wp_strip_all_tags( $raw_username );
  $username = remove_accents( $username );
  // Kill octets
  $username = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '', $username );
  $username = preg_replace( '/&.+?;/', '', $username ); // Kill entities

  // 网上很多教程都是直接将$strict赋值false，
  // 这样会绕过字符串检查，留下隐患
  if ($strict) {
    $username = preg_replace ('|[^a-z\p{Han}0-9 _.\-@]|iu', '', $username);
  }

  $username = trim( $username );
  // Consolidate contiguous whitespace
  $username = preg_replace( '|\s+|', ' ', $username );

  return $username;
}, 10, 3);

if (WP_DEVELOP) {
  add_filter( 'pre_option_upload_url_path', function() { return 'http://www.youngbirdplan.com.cn/wp-content/uploads'; } );
}

add_filter('pre_get_posts', function ($query) {

  if (is_admin()) return;

  if ($query->query['category_name'] === 'home-primary') {
    $limit = 2;
  }
  elseif ($query->query['category_name'] === 'home-secondary') {
    $limit = 6;
  }
  elseif ($query->query['post_type'] === 'work' && $_GET['event_id']) {
    $limit = 20;
    set_query_var('meta_key', 'event');
    set_query_var('meta_value', $_GET['event_id']);
  }
  elseif ($query->query['post_type'] === 'event' && !get_query_var('event') && $_GET['status']) {
    set_query_var('meta_key', 'status');
    set_query_var('meta_value', $_GET['status']);
  }
  elseif ($query->query['post_type'] === 'event' && !get_query_var('event') && isset($_GET['history'])) {
    set_query_var('meta_key', 'status');
    set_query_var('meta_value', 'history');
  }
  elseif ($query->query['post_type'] === 'event' && !get_query_var('event')) {
    set_query_var('meta_key', 'status');
    set_query_var('meta_compare', '!=');
    set_query_var('meta_value', 'history');
  }
  elseif ($query->query['post_type'] === 'judge') {
    $limit = 12;
  }
  elseif ($query->query['post_type'] === 'message') {
    set_query_var('meta_key', 'to');
    set_query_var('meta_value', get_current_user_id());
  } else {
    $limit = get_option('posts_per_page');
  }

  set_query_var('posts_per_archive_page', $limit);
});

function redirect_login ($force = false) {

  if (!$force && is_user_logged_in()) {
    return;
  }
  if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    status_header(401); exit;
  } else {
    header('Location: ' . pll_home_url() . 'sign-in/?intend=' . ($_SERVER['REQUEST_URI'])); exit;
  }
}

function get_event_status ($event_id) {
  $status = get_post_meta($event_id, 'status', true);
  $statuses = array (
    'starting' => __('即将开始', 'young-bird'),
    'started' => __('进行中', 'young-bird'),
    'ending' => __('即将结束', 'young-bird'),
    'endied' => __('已经结束', 'young-bird'),
    'judged' => __('评审完成', 'young-bird'),
    'history' => __('历史竞赛', 'young-bird')
  );
  return $statuses[$status];
}

function send_sms_code($mobile) {
  $code = generate_code($mobile);
  aliyun_send_sms($mobile, ALIYUN_SMS_TEMPLATE_VERIFY, array('code' => $code));
}

function generate_code($login) {
  $code = get_option('verify_' . $login);
  if (!$code) {
    $code = (string) rand(1000, 9999);
    update_option('verify_' . $login, $code);
  }
  return $code;
}

function verify_code($login, $input_code) {
  $code = get_option('verify_' . $login);
  delete_option('verify_' . $login);
  return $input_code === $code;
}

if (!function_exists('pll_home_url')) {
  function pll_home_url () {
    return site_url('/');
  }
}
