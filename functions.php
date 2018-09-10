<?php

require __DIR__ . '/includes/admin.php';
require __DIR__ . '/includes/aliyun.signature_helper.php';
require __DIR__ . '/includes/cap.php';
require __DIR__ . '/includes/cmb2.functions.php';
require __DIR__ . '/includes/cron.php';
require __DIR__ . '/includes/enqueue.php';
require __DIR__ . '/includes/lang.php';
require __DIR__ . '/includes/nav.php';
require __DIR__ . '/includes/post_type.php';

function redirect_login ($force = false) {

  if (!$force && is_user_logged_in()) {
    return;
  }
  if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    status_header(401); exit;
  } else {
    header('Location: ' . pll_home_url() . 'sign-in/?intend=' . urlencode($_SERVER['REQUEST_URI'])); exit;
  }
}

function get_event_status ($event_id) {
  $status = get_post_meta($event_id, 'status', true);
  $statuses = array (
    'starting' => __('即将开始', 'young-bird'),
    'started' => __('进行中', 'young-bird'),
    'ending' => __('即将结束', 'young-bird'),
    'ended' => __('已经结束', 'young-bird'),
    'judging' => __('评审开始', 'young-bird'),
    'judged' => __('评审完成', 'young-bird'),
    'second_judging' => __('二次评审', 'young-bird'),
    'history' => __('历史竞赛', 'young-bird')
  );
  return $statuses[$status];
}

function send_sms_code($mobile, $scene = 'register'/*or 'reset'*/) {
  $code = generate_code($mobile);
  aliyun_send_sms($mobile, constant('ALIYUN_SMS_TEMPLATE_VERIFY_' . strtoupper($scene)), array('code' => $code));
}

function send_email_code ($email, $scene = 'register'/*or 'reset'*/) {
  $code = generate_code($email);
  if ($scene === 'register') {
    wp_mail($email, '注册 - 邮件验证码', "[Young Bird Plan 嫩鸟计划] 感谢您的关注，您正在用邮箱注册Young Bird Plan平台，您的注册验证码是${code}\n\nThank you for your attention, you are using your email to register our website, here is your registration verification code ${code}");
  } elseif ($scene === 'reset') {
    wp_mail($email, '找回密码 - 邮件验证码', "[Young Bird Plan 嫩鸟计划] 您正在用邮箱找回Young Bird Plan平台的密码，您的验证码是${code}\n\nThank you for your attention, you are using your email to reset your password on our website, here is your verification code ${code}");
  }
}

function send_message ($to, $template_slug, $params = array()) {
  $lang = get_user_meta($to, 'lang', true) ?: pll_default_language();

  $templates = get_posts(array('post_type' => 'message_template', 'lang' => $lang, 'posts_per_page' => -1));

  $templates = array_values(array_filter($templates, function ($template) use ($template_slug) {
    return $template->post_name === $template_slug;
  }));

  if (!$templates) {
    error_log('Message template not found: ' . $template_slug . ', lang: ' . $lang);
    return;
  }
  $template = $templates[0];
  $template_content = $template->post_content;

  $message_title = replace_content_params($template->post_title, $params);
  $message_content = replace_content_params($template_content, $params);

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
      $result = wp_mail($to_user->user_email, $message_title, $message_content, 'Content-Type: text/html');
      error_log('发送邮件 ' . $template_slug . ' ' . $to_user->user_email . '. result: ' . var_export($result, true));
    }
    if ($sms_template = get_field('aliyun_sms_code', $template->ID) && $mobile = get_user_meta($to, 'mobile', true)){
      aliyun_send_sms($mobile, $sms_template, $params);
      error_log('发送短信 ' . $template_slug . ' ' . $mobile);
    }
  }

  $wx = new WeixinAPI(true);
  $unionid = get_user_meta(get_current_user_id(), 'wx_unionid', true);
  if ($unionid && $openid = get_option('wx_unionid_openid_' . $unionid)) {
    $wx->send_template_message($openid,
      WECHAT_TEMPLATE_MESSAGE_ID,
      pll_home_url(),
      array('first' => __('您在YoungBirdPlan官网上收到一条新消息，如您已在我们网站申请或报名参加竞赛，此信息可能较为重要，建议及时登录网站查收。', 'young-bird'),
        'keyword1' => '收到一条新消息',
        'keyword2' => '未读',
        'keyword3' => date('Y年m月d日 H:i', time() + get_option('gmt_offset') * HOUR_IN_SECONDS),
        'remark' => '点击即可登录网站查看！'
      ));
  }

}

function replace_content_params ($template, $params = array()) {
  $content = $template;
  foreach ($params as $key => $value) {
    $content = str_replace('${' . $key . '}', $value, $content);
  }
  return $content;
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

/**
 * @param $event_id string Event ID of any language version
 * @param null $user_id
 * @return mixed
 */
function get_event_group ($event_id, $user_id = null) {
  if (!$user_id) {
    $user_id = get_current_user_id();
  }

  $event_id_dl = pll_get_post($event_id, pll_default_language());

  $group = get_posts(array('post_type' => 'group', 'lang' => '', 'meta_query' => array(
    array('key' => 'event', 'value' => $event_id_dl),
    array('key' => 'members', 'value' => $user_id),
  )))[0];

  if (!$group) {
    $group = get_posts(array (
      'post_type' => 'group',
      'lang' => '',
      'meta_query' => array (
        array ('key' => 'event', 'value' => $event_id_dl),
        array ('key' => 'members_pending', 'value' => $user_id)
      )
    ))[0];
  }

  return $group;
}

/**
 * @param $event_id string Event id of any language version
 * @param null $user_id string search work of user (single or group)
 * @param null $group_id string  search work of group
 * @param bool $create create work before return
 * @return null|WP_Post group
 */
function get_event_work ($event_id, $user_id = null, $group_id = null, $create = false) {
  if (!$user_id) {
    $user_id = get_current_user_id();
  }

  $event_id_dl = pll_get_post($event_id, pll_default_language());

  if ($user_id) {
    // find my group in this event
    $group = get_event_group($event_id, $user_id);
    $group_id = $group->ID;
  }

  if ($group_id) {
    // find work of this group
    $work = get_posts(array('post_type' => 'work', 'lang' => '', 'meta_key' => 'group', 'meta_value' => $group_id))[0];
  } else {
    // find work of this author
    $work = get_posts(array('post_type' => 'work', 'lang' => '', 'author' => $user_id, 'meta_key' => 'event', 'meta_value' => $event_id_dl))[0];
  }

  if (!$work && $create) {
    $work_id = wp_insert_post(array (
      'post_type' => 'work',
      'post_status' => 'publish',
      'post_title' => __('新作品', 'young-bird'),
      'post_name' => $group_id ? (get_post_meta($event_id_dl, 'work_num_prefix', true) ?: $event_id_dl) . '-g' . $group_id : $event_id_dl . '-s' . $user_id,
      'post_author' => $user_id
    ));

    add_post_meta($work_id, 'event', $event_id_dl);

    if ($group_id) {
      add_post_meta($work_id, 'group', $group_id);
    }

    $work = get_post($work_id);
  }

  return $work;
}

function get_work_total_score ($work_id, $event_id = null) {

  if ($judge_score = get_post_meta($work_id, 'score', true)) {
    // get votes, votes of same event
    if (!$event_id) {
      $event_id = get_post_meta($work_id, 'event', true);
    }
    $vote_weight = get_post_meta($event_id, 'vote_weight', true) ?: 10;
    $votes = get_post_meta($work_id, 'votes', true) ?: 0;
    global $wpdb;
    $max_votes = $wpdb->get_var("select max(cast(meta_value as unsigned)) from {$wpdb->postmeta} where meta_key = 'votes' and post_id in (select post_id from {$wpdb->postmeta} where meta_value = '{$event_id}' and meta_key = 'event')");
    $vote_score = $max_votes ? ($votes / $max_votes * $vote_weight) : 0;
    return $judge_score + $vote_score;
  }
  else {
    return 0;
  }
}

function array_insert (&$array, $position, $insert) {
  if (is_int($position)) {
    array_splice($array, $position, 0, $insert);
  } else {
    $pos   = array_search($position, array_keys($array));
    $array = array_merge(
      array_slice($array, 0, $pos),
      $insert,
      array_slice($array, $pos)
    );
  }
}

function array_collect (array $input) {
  $output = array();
  foreach ($input as $key => $values) {
    foreach ($values as $index => $value) {
      if (!array_key_exists($index, $output)) {
        $output[$index] = array();
      }

      $output[$index][$key] = $value;
    }
  }
  return $output;
}
