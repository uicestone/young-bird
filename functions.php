<?php

require __DIR__ . '/includes/cmb2.functions.php';
require __DIR__ . '/includes/aliyun.signature_helper.php';
require __DIR__ . '/includes/cron.php';

remove_filter('template_redirect','redirect_canonical');

show_admin_bar(false);

add_action('after_switch_theme', function () {
  // foreach (array(
  //   'Judge Center', 'Judge Sign Up', 'Forget Password', 'Reset Password', 'Sign In', 'Sign Up', 'User Center'
  // ) as $name) {
  //   init_page_placeholder($name);
  // }

  // foreach (get_users() as $user) {
  //   $message_id = wp_insert_post(array('post_type' => 'message', 'post_title' => '欢迎注册', 'post_content' => '亲爱的 ' . $user->display_name . '，Young Bird Plan 欢迎您的加入。', 'post_status' => 'publish'));
  //   add_post_meta($message_id, 'to', $user->ID);
  // }

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

  if( ! class_exists('WeixinAPI') )
    echo '<div class="error"><p>' . __( '需要启用 WeixinAPI 插件' ) . '</p></div>';

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
    'show_ui' => false,
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
    'label' => __('单条消息', 'young-bird'),
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => false,
    'show_in_nav_menus' => false,
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
  wp_register_script('wx', 'http://res.wx.qq.com/open/js/jweixin-1.2.0.js', array(), '1.2.0', true);

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
    'save' => __('保存', 'young-bird'),
    'remind_event_ending' => __('竞赛报名即将截止通知', 'young-bird'),
    'remind_rank_published' => __('竞赛轮次发布通知', 'young-bird'),
    'generate_certs' => __('生成证书并发送通知', 'young-bird')
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
  if (class_exists('WeixinAPI') && WeixinAPI::in_wx()) {
    wp_enqueue_script('wx');
  }
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

add_filter('pre_get_posts', function (WP_Query $query) {

  if (is_admin()) return;

  if (isset($query->query['category_name']) && preg_match('/^home-primary/', $query->query['category_name'])) {
    $limit = 2;
  }
  elseif (isset($query->query['category_name']) && preg_match('/^home-secondary/', $query->query['category_name'])) {
    $limit = 6;
  }
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'work' && isset($_GET['event_id'])) {
    $limit = 20;
    $query->set('lang', '');

    $query->set('meta_value', $_GET['event_id']);

    if (isset($_GET['stage']) && $_GET['stage'] === 'rating') {
      $query->meta_query[] = array('key' => 'status', 'value' => '1');
    }
    
    $event_status = get_post_meta($_GET['event_id'], 'status', true);
    
    if ($event_status === 'second_judging') {
      $rank = get_posts(array('post_type' => 'rank', 'meta_query' => array(
        array('key' => 'event', 'value' => $_GET['event_id']),
        array('key' => 'stage', 'value' => 'second_rating')
      )))[0];
      $second_judging_work_ids = get_post_meta($rank->ID, 'works', true);
      $query->set('post__in', $second_judging_work_ids); 
    }

  }
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'event' && !get_query_var('event') && isset($_GET['status'])) {
    $query->set('meta_key', 'status');
    $query->set('meta_value', $_GET['status']);
  }
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'event' && !get_query_var('event') && isset($_GET['history'])) {
    $query->set('meta_key', 'status');
    $query->set('meta_value', 'history');
  }
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'event' && !get_query_var('event')) {
    $query->set('meta_key', 'status');
    $query->set('meta_compare', '!=');
    $query->set('meta_value', 'history');
  }
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'judge') {
    $limit = 12;
  }
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'message') {
    $query->set('meta_key', 'to');
    $query->set('meta_value', get_current_user_id());
    $query->set('lang', '');
  }

  if (empty($limit) && !$query->query['posts_per_page']) {
    $limit = get_option('posts_per_page');
  }

  $query->set('posts_per_archive_page', $limit);
});

add_filter('pre_get_posts', function (WP_Query $query) {
  if (isset($_GET['post__in'])) {
    $query->set('post__in', explode(',', $_GET['post__in']));
  }
  if (isset($query->query['post_type']) && $query->query['post_type'] === 'work' && isset($_GET['event_id'])) {
    $query->set('meta_key', 'event');
    $query->set('meta_value', $_GET['event_id']);
  }
  if (isset($query->query['post_type']) && $query->query['post_type'] === 'rank' && isset($_GET['event_id'])) {
    $query->set('meta_key', 'event');
    $query->set('meta_value', $_GET['event_id']);
  }
  if (isset($query->query['post_type']) && $query->query['post_type'] === 'event' && isset($_GET['attend_users'])) {
    $query->set('meta_key', 'attend_users');
    $query->set('meta_value', $_GET['attend_users']);
  }
});

add_filter('pre_get_users', function (WP_User_Query $query) {
  if (isset($_GET['attend_activities'])) {
    $query->set('meta_key', 'attend_activities');
    $query->set('meta_value', $_GET['attend_activities']);
  }
});

// update event status to 'second_judging' after rank save to 'second_rating'
add_action('acf/update_value/name=stage', function ($value, $post_id) {

  if (get_post_type($post_id) === 'rank' && get_field('stage', $post_id, true) !== 'second_rating' && $value === 'second_rating') {
    $event_id = get_post_meta($post_id, 'event', true);
    update_post_meta($event_id, 'status', 'second_judging');
  }

  return $value;

}, 10, 2);

// update rank work list
add_action('acf/update_value/name=ranking_judge', function ($value, $post_id) {
  if (get_post_type($post_id) === 'rank') {
    $rank_length = get_field('length', $post_id);
    $event_id = get_post_meta($post_id, 'event', true);
    $works = get_posts(array('post_type' => 'work', 'lang' => '', 'posts_per_page' => $rank_length, 'meta_query' => array(
      array('key' => 'event', 'value' => pll_get_post($event_id, pll_default_language())),
      array('key' => 'score', 'compare' => 'EXISTS')
    ), 'orderby' => 'meta_value_num', 'meta_key' => 'score', 'order' => 'DESC'));
    if (!$value) {
      usort($works, function ($work_a, $work_b) {
        return $work_a->ID < $work_b;
      });
    }
    $work_ids = array_column($works, 'ID');
    update_post_meta($post_id, 'works', $work_ids);
  }
  return $value;
}, 10, 2);

if (function_exists('mailusers_register_group_custom_meta_key_filter')) {

  // Define action to send to event participator using custom callback to generate the label
  add_action('mailusers_group_custom_meta_key_filter', function () {
    $events = array();
    mailusers_register_group_custom_meta_key_filter('attend_events', null, function ($mk, $mv) use ($events) {
      if (empty($events[$mv])) {
        $events[$mv] = get_the_title($mv);
      }
      return $events[$mv];
    });
  }, 5);

}

add_filter('post_row_actions', function ($actions, $post) {
  if ($attendable = get_post_meta($post->ID, 'attendable', true)) {
    $actions['attend_users'] = '<a href="' . admin_url('users.php?attend_activities=' . $post->ID) . '" target="_blank">' . __('报名用户', 'young-bird') . '</a>';
  }
  return $actions;
}, 10, 2);

// Add the custom columns to the message_template post type:
add_filter('manage_message_template_posts_columns', function ($column) {
  array_insert($column, 'date', array('slug' => __( '简称', 'young-bird')));
  return $column;
});


// Add the data to the custom columns for the message_template post type:
add_action('manage_message_template_posts_custom_column' , function ($column, $post_id) {
  switch ( $column ) {
    case 'slug' :
      echo get_post($post_id)->post_name;
      break;

  }
}, 10, 2 );

// Add the custom columns to the event post type:
add_filter('manage_event_posts_columns', function ($column) {
  array_insert($column, 'date', array(
    'works' => __( '作品', 'young-bird'),
    'ranks' => __( '轮次', 'young-bird')
  ));
  return $column;
});

// Add the data to the custom columns for the event post type:
add_action('manage_event_posts_custom_column' , function ($column, $post_id) {
  switch ( $column ) {
    case 'works' :
      echo '<a href="' . get_admin_url(null, 'edit.php?post_type=work&event_id=' . $post_id) . '">' . count(get_posts(array('post_type' => 'work', 'meta_key' => 'event', 'meta_value' => $post_id, 'posts_per_page' => -1))) . '</a>';
      break;
    case 'ranks' :
      echo '<a href="' . get_admin_url(null, 'edit.php?post_type=rank&event_id=' . $post_id) . '">' . count(get_posts(array('post_type' => 'rank', 'meta_key' => 'event', 'meta_value' => $post_id, 'posts_per_page' => -1))) . '</a>';
      break;
  }
}, 10, 2 );

// Add the custom columns to the event post type:
add_filter('manage_rank_posts_columns', function ($column) {
  array_insert($column, 'date', array(
    'event' => __( '竞赛', 'young-bird'),
    'works' => __( '作品', 'young-bird'),
  ));
  return $column;
});

// Add the data to the custom columns for the event post type:
add_action('manage_rank_posts_custom_column' , function ($column, $post_id) {
  switch ( $column ) {
    case 'event' :
      $event = get_field('event', $post_id);
      echo '<a href="' . get_admin_url(null, 'post.php?post=' . $event->ID . '&action=edit') . '">' . $event->post_title . '</a>';
      break;
    case 'works' :
      $work_ids = get_post_meta($post_id, 'works', true);
      echo '<a href="' . get_admin_url(null, 'edit.php?post_type=work&post__in=' . implode(',', $work_ids)) . '">' . count($work_ids) . '</a>';
      break;
  }
}, 10, 2 );

// Add the custom columns to the work post type:
add_filter('manage_work_posts_columns', function ($column) {
  unset($column['tags']);
  unset($column['author']);
  unset($column['title']);
  array_insert($column, 'date', array(
    'title_link' => __( '名称', 'young-bird'),
    'slug' => __( '编号', 'young-bird'),
    'authors' => __( '选手', 'young-bird'),
    'score' => __( '状态', 'young-bird')
  ));
  // var_export($column); exit;
  return $column;
});

// Add the data to the custom columns for the work post type:
add_action('manage_work_posts_custom_column' , function ($column, $post_id) {
  switch ( $column ) {
    case 'title_link' :
      echo '<a href="' . get_the_permalink($post_id) . '" target="_blank">' . get_the_title($post_id) . '</a>';
      break;
    case 'slug' :
      echo 'YB' . strtoupper(get_post($post_id)->post_name);
      break;
    case 'authors' :
      $group_id = get_post_meta($post_id, 'group', true);
      if ($group_id) {
        $group = get_post($group_id);
        echo $group->post_title . ': ';
        $member_ids = get_post_meta($group->ID, 'members');
        foreach ($member_ids as $member_id) {
          echo '<span style="margin-right:0.5em"><a href="' . get_admin_url(null, 'user-edit.php?user_id=' . $member_id) . '">' . get_user_by('ID', $member_id)->display_name . '</a></span>';
        }
      } else {
        $work = get_post($post_id);
        echo '<a href="' . get_admin_url(null, 'user-edit.php?user_id=' . $work->post_author) . '">' . get_user_by('ID', $work->post_author)->display_name . '</a>';
      }
      break;
    case 'score' :
      if ($score = get_post_meta($post_id, 'score', true)) {
        // get votes, votes of same event
        $event_id = get_post_meta($post_id, 'event', true);
        $vote_weight = get_post_meta($event_id, 'vote_weight', true) ?: 10;
        $votes = get_post_meta($post_id, 'votes', true);
        global $wpdb;
        $max_votes = $wpdb->get_var("select max(meta_value) from {$wpdb->postmeta} where meta_key = 'votes' and post_id in (select post_id from {$wpdb->postmeta} where meta_value = '{$event_id}' and meta_key = 'event')");
        $vote_score = $max_votes ? ($votes / $max_votes * $vote_weight) : 0;
        echo __('得分: ', 'young-bird') . ($score + $vote_score);
      } elseif ($status = get_post_meta($post_id, 'status', true)) {
        echo $status;
      } else {
        echo __('未入围', 'young-bird');
      }
      break;
  }
}, 10, 2 );

add_filter('manage_users_columns', function ( $column ) {
  unset($column['nickname']);
  unset($column['posts']);
  array_insert($column, 'email', array('name' => __( '姓名', 'young-bird')));
  array_insert($column, 'role', array('mobile' => __( '手机', 'young-bird')));
  array_insert($column, 'role', array('works' => __( '作品', 'young-bird')));
  array_insert($column, 'role', array('events' => __( '竞赛', 'young-bird')));
  array_insert($column, 'role', array('country' => __( '国家', 'young-bird')));
  return $column;
});

add_filter( 'manage_users_custom_column', function ($val, $column_name, $user_id) {
  switch ($column_name) {
    case 'name' :
      return get_user_meta($user_id, 'name', true);
      break;
    case 'mobile' :
      return get_user_meta($user_id, 'mobile', true);
      break;
    case 'country' :
      return get_user_meta($user_id, 'country', true);
      break;
    case 'events' :
      return '<a href="' . get_admin_url(null, 'edit.php?post_type=event&attend_users=' . $user_id) . '">' . count(get_user_meta($user_id, 'attend_events')) . '</a>';
      // TODO attended_user needs to be filtered in event
      break;
    case 'works' :
      return '<a href="' . get_admin_url(null, 'edit.php?post_type=work&author=' . $user_id) . '">' . count(get_posts(array('post_type' => 'work', 'author' => $user_id, 'posts_per_page' => -1))) . '</a>';
      break;
    default:
  }
  return $val;
}, 10, 3 );

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
      wp_mail($to_user->user_email, $message_title, $message_content, 'Content-Type: text/html');
    }
    else if ($mobile = get_user_meta($to, 'mobile', true)){
      aliyun_send_sms($mobile, get_field('aliyun_sms_code', $template->ID), $params);
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

function array_insert(&$array, $position, $insert) {
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

add_action('admin_footer', function () {
  $screen = get_current_screen();
  if ( $screen->id != "users" )   // Only add to users.php page
    return;
  ?>
  <script type="text/javascript">
		jQuery(document).ready( function($)
		{
			$('.tablenav.top .clear, .tablenav.bottom .clear').before('<form method="POST"><input type="hidden" id="ybp_export_users" name="ybp_export_users" value="1" /><input class="button user_export_button" style="margin-top:3px;" type="submit" value="<?=__('导出', 'young-bird')?>" /></form>');
		});
  </script>
  <?php
});

add_action('admin_init', function () {
  if (!empty($_POST['ybp_export_users']) && current_user_can('manage_options')) {
    // export users in xlsx file
    exit;
  }
});

add_action('admin_footer', function () {
  $screen = get_current_screen();
  if ( $screen->id != "edit-work" )   // Only add to users.php page
    return;
  ?>
  <script type="text/javascript">
		jQuery(document).ready( function($)
		{
			$('.tablenav.top .clear, .tablenav.bottom .clear').before('<form method="POST"><input type="hidden" id="ybp_export_works" name="ybp_export_works" value="1" /><input class="button user_export_button" style="margin-top:3px;" type="submit" value="<?=__('导出', 'young-bird')?>" /></form>');
		});
  </script>
  <?php
});

add_action('admin_init', function () {
  if (!empty($_POST['ybp_export_works']) && current_user_can('manage_options')) {
    // export users in xlsx file
    exit;
  }
});
