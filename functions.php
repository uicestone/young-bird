<?php

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
  'show_ui' => true,
  'show_in_menu' => true,
  'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
  'taxonomies' => array('post_tag', 'category'),
  'menu_icon' => 'dashicons-admin-customizer',
  'has_archive' => 'true'
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
  'show_ui' => true,
  'show_in_menu' => true,
  'supports' => array('title', 'excerpt', 'editor', 'thumbnail'),
  'taxonomies' => array('post_tag', 'category'),
  'menu_icon' => 'dashicons-welcome-learn-more',
  'has_archive' => 'true'
));

add_action('wp', function() {

  wp_register_style('main', get_stylesheet_directory_uri() . '/css/main.css', array(), '1.0.0');
  wp_register_style('fontawesome', get_stylesheet_directory_uri() . '/css/fontawesome.css', array(), '5.0.4');

  wp_register_script('jquery', get_stylesheet_directory_uri() . '/js/jquery-3.2.1.slim.min.js', array(), '3.2.1', true);
  wp_register_script('bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.0.0-beta.3', true);
  wp_register_script('jquery.sortable', get_stylesheet_directory_uri() . '/js/jquery.sortable.min.js', array('jquery'), false, true);
  wp_register_script('html.sortable', get_stylesheet_directory_uri() . '/js/html.sortable.min.js', array(), false, true);
  wp_register_script('popper', get_stylesheet_directory_uri() . '/js/popper.min.js', array('jquery'), false, true);
  wp_register_script('main', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
});

add_action('wp_enqueue_scripts', function(){
  wp_enqueue_style('main');
  wp_enqueue_style('fontawesome');

  wp_enqueue_script('jquery');
  wp_enqueue_script('bootstrap');
  wp_enqueue_script('popper');
});
