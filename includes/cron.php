<?php

add_action('after_switch_theme', function () {
	if (!wp_next_scheduled('sync_unionid_openids')) {
		wp_schedule_event(strtotime('+1 hour') - time() % 3600, 'hourly', 'sync_unionid_openids');
	}
});

add_action('sync_unionid_openids', 'sync_unionid_openids');

function sync_unionid_openids () {
  global $wpdb;
  $wx = new WeixinAPI(true);
  $openids = $wx->get_user_openids();
  $openids_exists = $wpdb->get_col("select option_value from {$wpdb->options} where option_name like 'wx_unionid_openid_%'");
  $new_openids = array_diff($openids, $openids_exists);
  foreach ($new_openids as $openid) {
    $user_info = $wx->get_user_info($openid);
    $unionid = $user_info->unionid;
    if ($unionid) {
      update_option('wx_unionid_openid_' . $unionid, $openid, false);
    }
  }
}
