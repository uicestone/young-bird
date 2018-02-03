<?php

add_action('after_switch_theme', function () {
  foreach (array(
    'Judge Center', 'Judge Sign Up', 'Forgot Password', 'Participate Event', 'Reset Password', 'Sign In', 'Sign Up', 'User Center'
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
  'menu_icon' => 'dashicons-megaphone',
));

