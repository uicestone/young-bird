<?php

require __DIR__ . '/includes/cmb2.functions.php';
require __DIR__ . '/includes/aliyun.signature_helper.php';

remove_filter('template_redirect','redirect_canonical');

show_admin_bar(false);

add_action('after_switch_theme', function () {
  // foreach (array(
  //   'Judge Center', 'Judge Sign Up', 'Forget Password', 'Reset Password', 'Sign In', 'Sign Up', 'User Center'
  // ) as $name) {
  //   init_page_placeholder($name);
  // }

  foreach (get_users() as $user) {
    $message_id = wp_insert_post(array('post_type' => 'message', 'post_title' => '欢迎注册', 'post_content' => '亲爱的 ' . $user->display_name . '，Young Bird Plan 欢迎您的加入。', 'post_status' => 'publish'));
    add_post_meta($message_id, 'to', $user->ID);
  }

  add_role('judge', __('大咖', 'young-bird'), array());
  add_role('attendee', __('选手', 'young-bird'), array());
  remove_role('subscriber'); remove_role('author'); remove_role('contributor');

  $judge_role = get_role('judge'); $judge_role->add_cap('judge_works');

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
    echo '<div class="error"><p>' . __( '需要启用 Advanced Custom Fields 插件' ) . '</p></div>';

  if ( ! function_exists('new_cmb2_box'))
    echo '<div class="error"><p>' . __( '需要启用 CMB2 插件' ) . '</p></div>';

  if( ! function_exists('the_subtitle') )
    echo '<div class="error"><p>' . __( '需要启用 Subtitles 插件' ) . '</p></div>';

} );

add_action('admin_menu', function () {
  remove_menu_page( 'edit-comments' );
});

add_theme_support('post-thumbnails');

add_action('init', function () {

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

  register_post_type('message_template', array(
    'label' => __('消息', 'young-bird'),
    'labels' => array(
      'all_items' => __('所有消息模版', 'young-bird'),
      'add_new' => __('添加消息模版', 'young-bird'),
      'add_new_item' => __('新消息模版', 'young-bird'),
      'edit_item' => __('编辑消息模版', 'young-bird'),
      'not_found' => __('未找到消息模版', 'young-bird')
    ),
    'public' => true,
    'supports' => array('title', 'editor'),
    'menu_icon' => 'dashicons-email',
  ));

  register_post_type('message', array(
    'public' => false,
    'publicly_queryable' => true,
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

  // Localize the script with new data
  $translation_array = array(
    'ok' => __('确定', 'young-bird'),
    'cancel' => __('取消', 'young-bird'),
    'confirm_role' => __('是否确认您的参赛身份，确认后将不能变更', 'young-bird'),
    'confirm_participate' => __('确定报名此活动吗？', 'young-bird'),
    'pass' => __('入围', 'young-bird'),
    'reject' => __('不入围', 'young-bird'),
    'score' => __('分数：', 'young-bird'),
    'comment' => __('评论', 'young-bird'),
    'resend' => __('重新发送', 'young-bird'),
    'sent' => __('已发送', 'young-bird'),
    'save' => __('保存', 'young-bird')
  );
  wp_localize_script( 'main', 'locale', $translation_array );
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

if (WP_REMOTE_UPLOADS) {
  add_filter( 'pre_option_upload_url_path', function() { return 'http://www.youngbirdplan.com.cn/wp-content/uploads'; } );
}

add_filter('pre_get_posts', function ($query) {

  if (is_admin()) return;

  if (preg_match('/^home-primary/', $query->query['category_name'])) {
    $limit = 2;
  }
  elseif (preg_match('/^home-secondary/', $query->query['category_name'])) {
    $limit = 6;
  }
  elseif ($query->query['post_type'] === 'work' && $_GET['event_id']) {
    $limit = 20;
    set_query_var('lang', '');

    if (isset($_GET['stage']) && $_GET['stage'] === 'rating') {
      set_query_var('meta_query', array(
        array('key' => 'event', 'value' => $_GET['event_id']),
        array('key' => 'status', 'value' => '1')
      ));
    } else {
      set_query_var('meta_key', 'event');
      set_query_var('meta_value', $_GET['event_id']);
    }

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
    set_query_var('lang', '');
  } else {
    $limit = get_option('posts_per_page');
  }

  set_query_var('posts_per_archive_page', $limit);
});

// update event status to 'second_judging' after rank save to 'second_rating'
add_action('acf/update_value/name=stage', function ($value, $post_id) {

  if (get_post_type($post_id) === 'rank' && get_field('stage', $post_id, true) !== 'second_rating' && $value === 'second_rating') {
    $event_id = get_post_meta($post_id, 'event', true);
    update_post_meta($event_id, 'status', 'second_judging');
  }

  return $value;
  
}, 10, 2);

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
    'judging' => __('评审开始', 'young-bird'),
    'judged' => __('评审完成', 'young-bird'),
    'history' => __('历史竞赛', 'young-bird')
  );
  return $statuses[$status];
}

function send_sms_code($mobile, $scene = 'register'/*or 'reset'*/) {
  $code = generate_code($mobile);
  aliyun_send_sms($mobile, constant('ALIYUN_SMS_TEMPLATE_VERIFY_' . strtoupper($scene)), array('code' => $code));
}

function send_email_code ($email) {
  $code = generate_code($email);
  wp_mail($email, '邮件验证码', "[Young Bird Plan 嫩鸟计划] 感谢您的关注，您正在用邮箱注册Young Bird Plan平台，您的注册验证码是${code}\n\nThank you for your attention, you are using your email to register our website, here is your registration verification code ${code}");
}

function send_message ($to, $template_slug, $vars = array()) {
  $lang = get_user_meta($to, 'lang', true) ?: pll_default_language();

  $templates = get_posts(array('post_type' => 'message_template', 'lang' => $lang, 'posts_per_page' => -1));

  $templates = array_filter($templates, function ($template) use ($template_slug) {
    return $template->post_name === $template_slug;
  });

  if (!$templates) {
    error_log('Message template not found: ' . $template_slug . ', lang: ' . $lang);
    return;
  }
  $template = $templates[0];
  $template_content = $template->post_content;

  $args_title = array_merge(array($template->post_title), $vars);
  $message_title = call_user_func_array('sprintf', $args_title);
  $args_content = array_merge(array($template_content), $vars);
  $message_content = call_user_func_array('sprintf', $args_content);

  $message_id = wp_insert_post(array('post_type' => 'message',
    'post_status' => 'publish',
    'post_title' => $message_title,
    'post_content' => $message_content
  ));

  add_post_meta($message_id, 'to', $to);
  $unread_messages = get_user_meta($to, 'unread_messages', true) ?: 0;
  update_user_meta($to, 'unread_messages', ++$unread_messages);
  update_user_meta($to, 'has_unread_message', 1);

  if (get_field('external', $template->ID)) {
    $to_user = get_user_by('ID', $to);
    if ($to_user->user_email) {
      wp_mail($to_user->user_email, $message_title, $message_content);
    }
    else if ($mobile = get_user_meta($to, 'mobile', true)){
      aliyun_send_sms($mobile, get_field('aliyun_sms_code', $template->ID), $vars);
    }
  }
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

add_filter('lostpassword_url', function ($default_url) {
  if (is_admin()) {
    return $default_url;
  } else {
    return pll_home_url() . 'forget-password/';
  }
});

function get_event_group ($event_id, $user_id = null) {
  if (!$user_id) {
    $user_id = get_current_user_id();
  }

  return get_posts(array('post_type' => 'group', 'meta_query' => array(
    array('key' => 'event', 'value' => $event_id),
    array('key' => 'member', 'value' => $user_id),
  )))[0];
}

function get_event_work ($event_id, $user_id = null) {
  if (!$user_id) {
    $user_id = get_current_user_id();
  }

  return get_posts(array('post_type' => 'work', 'author' => $user_id, 'meta_key' => 'event', 'meta_value' => $event_id))[0];
}

function language_slug_suffix () {
  if (pll_current_language() === pll_default_language()) {
    return '';
  }
  else {
    return '-' . pll_current_language();
  }
}
