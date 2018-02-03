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
