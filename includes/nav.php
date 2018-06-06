<?php

remove_filter('template_redirect','redirect_canonical');

if (defined('WP_REMOTE_UPLOADS') && WP_REMOTE_UPLOADS) {
  add_filter( 'pre_option_upload_url_path', function() { return 'https://www.youngbirdplan.com.cn/wp-content/uploads'; } );
}

add_filter('lostpassword_url', function ($default_url) {
  if (is_admin()) {
    return $default_url;
  } else {
    return pll_home_url() . 'forget-password/';
  }
});
