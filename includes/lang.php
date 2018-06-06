<?php

add_action('after_switch_theme', function () {
  load_theme_textdomain('young-bird', get_template_directory() . '/languages');
});

add_action('wp', function() {

  // Localize the script with new data
  $translation_array = array(
    '__' => pll_current_language(),
    'ok' => __('确定', 'young-bird'),
    'cancel' => __('取消', 'young-bird'),
    'confirm_role' => __('是否确认您的参赛身份，确认后将不能变更', 'young-bird'),
    'confirm_attend_event_review' => __('确定申请报名此竞赛吗？', 'young-bird'),
    'pass' => __('入围', 'young-bird'),
    'reject' => __('不入围', 'young-bird'),
    'score' => __('分数：', 'young-bird'),
    'comment' => __('评论', 'young-bird'),
    'resend' => __('重新发送', 'young-bird'),
    'sent' => __('已发送', 'young-bird'),
    'save' => __('保存', 'young-bird'),
    'remind_event_ending' => __('竞赛报名即将截止通知', 'young-bird'),
    'remind_rank_published' => __('竞赛轮次发布通知', 'young-bird'),
    'generate_certs' => __('生成证书并发送通知', 'young-bird')
  );
  wp_localize_script( 'main', 'locale', $translation_array );
});

function language_slug_suffix () {
  if (pll_current_language() === pll_default_language()) {
    return '';
  }
  else {
    return '-' . pll_current_language();
  }
}
