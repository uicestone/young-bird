<?php

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
    'supports' => array('title', 'excerpt', 'thumbnail', 'author'),
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

add_filter('pre_get_posts', function (WP_Query $query) {

  // effective only in user end main loop
  if (is_admin() || !is_archive() || $query->query['posts_per_page'] === -1) return;

  // home-primary(-en) posts
  if (empty($query->query['post_type']) && isset($query->query['category_name']) && preg_match('/^home-primary/', $query->query['category_name'])) {
    $limit = 2;
  }
  // home-secondary(-en) posts
  elseif (isset($query->query['category_name']) && preg_match('/^home-secondary/', $query->query['category_name'])) {
    $limit = 6;
  }
  // work review page
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'work' && isset($_GET['event_id'])) {
    $limit = 20;
    $query->set('lang', '');

    $query->set('meta_query', array(
      array('key' => 'event', 'value' => $_GET['event_id'])
    ));

    if (isset($_GET['stage']) && $_GET['stage'] === 'rating') {
      $query->query_vars['meta_query'][] = array('key' => 'status', 'value' => '1');
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
  // event list - filter by status
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'event' && !get_query_var('event') && isset($_GET['status'])) {
    $query->set('meta_key', 'status');
    $query->set('meta_value', $_GET['status']);
  }
  // event history list
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'event' && !get_query_var('event') && isset($_GET['history'])) {
    $query->set('meta_key', 'status');
    $query->set('meta_value', 'history');
  }
  // event list
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'event' && !get_query_var('event')) {
    $query->set('meta_key', 'status');
    $query->set('meta_compare', '!=');
    $query->set('meta_value', 'history');
  }
  // judge post list
  elseif (isset($query->query['post_type']) && $query->query['post_type'] === 'judge') {
    $limit = 12;
  }
  // user center message list
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

add_filter('the_title', function ($title, $post_id) {

  $post_type = get_post_type($post_id);

  if ($post_type === 'event') {
    $findthese = array(
      '#' . sprintf(__('Private: %s'), '') . '#'
    );

    $replacewith = array(
      __('微竞赛：', 'young-bird') // What to replace "Private:" with
    );

    $title = preg_replace($findthese, $replacewith, $title);
  }

  return $title;
}, 10, 2);
