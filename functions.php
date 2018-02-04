<?php

remove_filter('template_redirect','redirect_canonical');

show_admin_bar(false);

add_action('after_switch_theme', function () {
  foreach (array(
    'Judge Center', 'Judge Sign Up', 'Forget Password', 'Participate Event', 'Reset Password', 'Sign In', 'Sign Up', 'User Center'
  ) as $name) {
    init_page_placeholder($name);
  }
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
} );

add_action('admin_menu', function () {
  remove_menu_page( 'edit-comments' );
});

register_post_type('event', array(
  'label' => '竞赛',
  'labels' => array(
    'all_items' => '所有竞赛',
    'add_new' => '添加竞赛',
    'add_new_item' => '新竞赛',
    'edit_item' => '编辑竞赛',
    'not_found' => '未找到竞赛'
  ),
  'public' => true,
  'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
  'taxonomies' => array('post_tag', 'category'),
  'menu_icon' => 'dashicons-admin-customizer',
  'has_archive' => true
));

register_post_type('rank', array(
  'label' => '排名',
  'labels' => array(
    'all_items' => '所有排名',
    'add_new' => '添加排名',
    'add_new_item' => '新排名',
    'edit_item' => '编辑排名',
    'not_found' => '未找到排名'
  ),
  'public' => true,
  'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
  'taxonomies' => array('post_tag', 'category'),
  'menu_icon' => 'dashicons-thumbs-up ',
  'has_archive' => true
));

register_post_type('group', array(
  'label' => '团队',
  'labels' => array(
    'all_items' => '所有团队',
    'add_new' => '添加团队',
    'add_new_item' => '新团队',
    'edit_item' => '编辑团队',
    'not_found' => '未找到团队'
  ),
  'public' => true,
  'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
  'taxonomies' => array('post_tag', 'category'),
  'menu_icon' => 'dashicons-groups',
  'has_archive' => true
));

register_post_type('work', array(
  'label' => '作品',
  'labels' => array(
    'all_items' => '所有作品',
    'add_new' => '添加作品',
    'add_new_item' => '新作品',
    'edit_item' => '编辑作品',
    'not_found' => '未找到作品'
  ),
  'public' => true,
  'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
  'taxonomies' => array('post_tag', 'category'),
  'menu_icon' => 'dashicons-admin-customizer',
  'has_archive' => true
));

register_post_type('judge', array(
  'label' => '大咖',
  'labels' => array(
    'all_items' => '所有大咖',
    'add_new' => '添加大咖',
    'add_new_item' => '新大咖',
    'edit_item' => '编辑大咖',
    'not_found' => '未找到大咖'
  ),
  'public' => true,
  'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
  'taxonomies' => array('post_tag', 'category'),
  'menu_icon' => 'dashicons-welcome-learn-more',
  'has_archive' => true
));

register_post_type('message', array(
  'label' => '消息',
  'labels' => array(
    'all_items' => '所有消息',
    'add_new' => '添加消息',
    'add_new_item' => '新消息',
    'edit_item' => '编辑消息',
    'not_found' => '未找到消息'
  ),
  'public' => true,
  'supports' => array('title', 'editor', 'author'),
  'menu_icon' => 'dashicons-email',
  'has_archive' => true
));

add_action('wp', function() {

  wp_register_style('main', get_stylesheet_directory_uri() . '/css/main.css', array(), '1.0.0');
  wp_register_style('fontawesome', get_stylesheet_directory_uri() . '/css/fontawesome.css', array(), '5.0.4');
  wp_register_style('fancybox', get_stylesheet_directory_uri() . '/css/jquery.fancybox.min.css', array(), '5.0.4');

  wp_register_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-3.2.1.slim.min.js', array(), '3.2.1', true);
  wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.0.0-beta.3', true);
  wp_register_script('html.sortable', get_stylesheet_directory_uri() . '/js/html.sortable.min.js', array(), false, true);
  wp_register_script('fancybox', get_stylesheet_directory_uri() . '/js/jquery.fancybox.min.js', array(), false, true);
  wp_register_script('popper', get_stylesheet_directory_uri() . '/js/popper.min.js', array('jquery'), false, true);
  wp_register_script('main', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
});

add_action('wp_enqueue_scripts', function(){
  wp_enqueue_style('main');
  wp_enqueue_style('fontawesome');
  wp_enqueue_style('fancybox');

  wp_enqueue_script('jquery');
  wp_enqueue_script('bootstrap');
  wp_enqueue_script('popper');
  wp_enqueue_script('fancybox');
  wp_enqueue_script('html.sortable');
  wp_enqueue_script('main');
});
