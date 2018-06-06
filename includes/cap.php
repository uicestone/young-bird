<?php

add_action('after_switch_theme', function () {
  add_role('judge', __('大咖', 'young-bird'), array());
  add_role('attendee', __('选手', 'young-bird'), array());
  remove_role('subscriber'); remove_role('author'); remove_role('contributor');

  $judge_role = get_role('judge'); $judge_role->add_cap('judge_works');
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
