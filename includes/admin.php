<?php

show_admin_bar(false);

add_action( 'admin_notices', function () {
  if( ! function_exists('get_fields') )
    echo '<div class="error"><p>' . __( '需要启用 Advanced Custom Fields 插件' ) . '</p></div>';

  if ( ! function_exists('new_cmb2_box'))
    echo '<div class="error"><p>' . __( '需要启用 CMB2 插件' ) . '</p></div>';

  if( ! function_exists('the_subtitle') )
    echo '<div class="error"><p>' . __( '需要启用 Subtitles 插件' ) . '</p></div>';

  if( ! class_exists('WeixinAPI') )
    echo '<div class="error"><p>' . __( '需要启用 WeixinAPI 插件' ) . '</p></div>';

  if( ! class_exists('Intervention\Image\ImageManagerStatic') )
    echo '<div class="error"><p>' . __( '需要启用 WP Intervention 插件' ) . '</p></div>';

  if( ! class_exists('XLSXWriter') )
    echo '<div class="error"><p>' . __( '需要启用 WP PHP XLSWriter 插件' ) . '</p></div>';

  if( !function_exists('pll_default_language') || pll_default_language() !== 'zh')
    echo '<div class="error"><p>' . __( '需要启用 Polylang 插件，并设置默认语言为 “zh”' ) . '</p></div>';

} );

add_action('admin_menu', function () {
  remove_menu_page( 'edit-comments' );
});

add_filter('pre_get_posts', function (WP_Query $query) {
  // effective only in admin panel
  if (!is_admin()) return;

  if (isset($_GET['post__in'])) {
    $query->set('post__in', explode(',', $_GET['post__in']));
  }
  if (isset($query->query['post_type']) && $query->query['post_type'] === 'work' && isset($_GET['event_id'])) {
    $query->set('meta_key', 'event');
    $query->set('meta_value', $_GET['event_id']);
  }
    if (isset($query->query['post_type']) && $query->query['post_type'] === 'campus_apply' && isset($_GET['campus_id'])) {
        $query->set('meta_key', 'campus_id');
        $query->set('meta_value', $_GET['campus_id']);
    }


    if (isset($query->query['post_type']) && $query->query['post_type'] === 'qaa' && isset($_GET['event_id'])) {
        $query->set('meta_key', 'event_id');
        $query->set('meta_value', $_GET['event_id']);
    }

    if (isset($query->query['post_type']) && $query->query['post_type'] === 'campus_apply' && isset($_GET['uid'])) {
        $query->set('author', $_GET['uid']);
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
    // effective only in admin panel
    if (!is_admin()) return;

    if (isset($_GET['attend_activities'])) {
        $query->set('meta_key', 'attend_activities');
        $query->set('meta_value', $_GET['attend_activities']);
    }

    if (isset($_GET['attend_event_review'])) {
        $query->set('meta_key', 'attend_event_review');
        $query->set('meta_value', $_GET['attend_event_review']);
    }

    if (isset($_GET['attend_events'])) {
        $query->set('meta_key', 'attend_events');
        $query->set('meta_value', $_GET['attend_events']);
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
    $event_id_dl = pll_get_post($event_id, pll_default_language());

    // get all work in this event
    $works = get_posts(array(
      'post_type' => 'work',
      'lang' => '',
      'posts_per_page' => -1,
      'meta_query' => array(
        array('key' => 'event', 'value' => $event_id_dl),
        array('key' => 'status', 'value' => '1')
      )
    ));

    // calculate total score
    $works = array_map(function ($work) {
      $total_score = get_work_total_score($work->ID);
      $work->total_score = $total_score;
      return $work;
    }, $works);

    usort($works, function ($work_a, $work_b) {
      return round(($work_b->total_score - $work_a->total_score) * 10000);
    });

    $works = array_slice($works, 0, $rank_length);

    if (!$value) {
      usort($works, function ($work_a, $work_b) {
        return $work_a->ID - $work_b->ID;
      });
    }

    $work_ids = array_column($works, 'ID');
    update_post_meta($post_id, 'works', $work_ids);

    foreach ($work_ids as $work_id) {
      update_post_meta($work_id, 'furthest_rank_length', $rank_length);
    }

    global $wpdb;
    // insert new rank_length, on duplicate ignore
    $insert_query = "replace into {$wpdb->postmeta} (post_id, meta_key, meta_value) values ";
    $insert_values = array_map(function ($work_id) use ($post_id) {
      return "({$work_id}, 'rank', {$post_id})";
    }, $work_ids);

    $insert_query .= implode(', ', $insert_values);
    $wpdb->query($insert_query);

    $work_ids_string = implode(',', $work_ids);
    $delete_query = "delete from {$wpdb->postmeta} where meta_key = 'rank' and post_id not in ({$work_ids_string}) and meta_value = {$post_id}";
    $wpdb->query($delete_query);
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
  if ($post->post_type === 'post' && $attendable = get_post_meta($post->ID, 'attendable', true)) {
    $actions['attend_users'] = '<a href="' . admin_url('users.php?attend_activities=' . pll_get_post($post->ID, pll_default_language())) . '">' . __('报名用户', 'young-bird') . '</a>';
  }
    if ($post->post_type === 'campus') {
     //   $actions['attend_users'] = '<a href="' . admin_url('users.php?attend_activities=' . pll_get_post($post->ID, pll_default_language())) . '">' . __('报名用户', 'young-bird') . '</a>';
        $actions['campus_applys'] = '<a href="' . admin_url('edit.php?post_type=campus_apply&campus_id=' . pll_get_post($post->ID, pll_default_language())) . '">' . __('报名用户', 'young-bird') . '</a>';

    }
  if ($post->post_type === 'event') {
    $actions['attend_users'] = '<a href="' . admin_url('users.php?role=attendee&attend_events=' . pll_get_post($post->ID, pll_default_language())) . '">' . __('报名用户', 'young-bird') . '</a>';
    $actions['event_qa'] = '<a href="' . admin_url('edit.php?post_type=qa&event_id=' . pll_get_post($post->ID, pll_default_language())) . '">' . __('答疑', 'young-bird') . '</a>';
    if (get_field('attend_review', $post->ID)) {
      $actions['attend_review_users'] = '<a href="' . admin_url('users.php?role=attendee&attend_event_review=' . pll_get_post($post->ID, pll_default_language())) . '">' . __('申请报名用户', 'young-bird') . '</a>';
    }
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

add_action('manage_event_posts_custom_column' , function ($column, $post_id) {
    $id_dl = pll_get_post($post_id, pll_default_language());
    switch ( $column ) {
        case 'works' :
            echo '<a href="' . get_admin_url(null, 'edit.php?post_type=work&event_id=' . $id_dl) . '">' . count(get_posts(array('post_type' => 'work', 'lang' => '', 'meta_key' => 'event', 'meta_value' => pll_get_post($post_id, pll_default_language()), 'posts_per_page' => -1))) . '</a>';
            break;
        case 'ranks' :
            echo '<a href="' . get_admin_url(null, 'edit.php?post_type=rank&event_id=' . $id_dl) . '">' . count(get_posts(array('post_type' => 'rank', 'meta_key' => 'event', 'meta_value' => $post_id, 'posts_per_page' => -1))) . '</a>';
            break;
    }
}, 10, 2 );
add_filter('manage_qaa_posts_columns', function ($column) {
    array_insert($column, 'date', array(

        'answer' => __( '回答', 'young-bird'),
        'event' => __( '所属竞赛', 'young-bird'),
        'customer_publish'=>'发布'
    ));
    return $column;
});




add_action('manage_qaa_posts_custom_column' , function ($column, $post_id) {
    $id_dl = pll_get_post($post_id, pll_default_language());
    switch ( $column ) {
        case 'answer' :
            $answer=get_post_meta($post_id,'answer_user',true);
            if($answer) {


                echo '回答者：'.get_user_meta($answer,'name',true);
                }
                else {
                    echo '<a href="/answer?id=' . $post_id . '">回答</a>';
                }
            break;
        case 'event' :
            $answer=get_post_meta($post_id,'event_id',true);
            echo get_post($answer)->post_title;
            break;
        case 'customer_publish' :

            $status=get_post_meta($post_id,'customer_publish',true);
            if($status==true)
            {
                echo '<a href="/publish_qa/?qa_id=' . ($post_id) . '&fail='.$post_id.'&destination='. home_url(add_query_arg(array())).'" target="_blank">改为不发布</a>';
            }
            else {
                echo '<a href="/publish_qa/?qa_id=' . ($post_id) . '&pass=' . $post_id . '&destination=' . home_url(add_query_arg(array())) . '" target="_blank"> 发布</a>&nbsp;';
            }
            break;
    }
}, 10, 2 );


// Add the data to the custom columns for the event post type:


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
      $event_id_dl = get_post_meta($post_id, 'event', true);
      $event = get_post(pll_get_post($event_id_dl));
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
    'image_count' => __( '图片', 'young-bird'),
    'authors' => __( '选手', 'young-bird'),
    'author' => __( '编辑', 'young-bird'),
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
    case 'image_count' :
      echo count(get_post_meta($post_id, 'images'));
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
    case 'author' :
      $work = get_post($post_id);
      echo '<a href="' . get_admin_url(null, 'user-edit.php?user_id=' . $work->post_author) . '">' . get_user_by('ID', $work->post_author)->display_name . '</a>';
      break;
    case 'score' :
      if ($score = get_post_meta($post_id, 'score', true)) {
        $total_score = get_work_total_score($post_id);
        echo __('总分: ', 'young-bird') . round($total_score, 2);
      } elseif ($status = get_post_meta($post_id, 'status', true)) {
        echo __('入围', 'young-bird');;
      } else {
        echo __('未入围', 'young-bird');
      }
      break;
  }
}, 10, 2 );






add_filter('manage_campus_apply_posts_columns', function ($column) {

    array_insert($column, 'date', array(
         'apply_school'=>__( '申请学校', 'young-bird'),
        'event'=>__( '所属站长', 'young-bird'),
        'author' => __( '申请人', 'young-bird'),
        'apply_count'=>__( '申请次数', 'young-bird'),

        'apply_score'=>__( '平均分', 'young-bird'),
        'status'=> __( '状态', 'young-bird'),

        'auditing'=>__( '审核', 'young-bird'),
        'campus_image_status'=>'图片状态',
        'campus_image_exam'=>'审核图片',
        'download'=>__( '下载', 'young-bird'),

    ));

    // var_export($column); exit;

    return $column;
});

// Add the data to the custom columns for the work post type:
add_action('manage_campus_apply_posts_custom_column' , function ($column, $post_id) {
    switch ( $column ) {
        case 'apply_school':
            $schools=get_post_meta($post_id,'school_id',true);
            foreach($schools as $school1){

                echo get_post($school1)->post_title.',';
            }
            break;
        case 'event':
            $campus_id=get_post_meta($post_id,'campus_id',true);
            echo get_post($campus_id)->post_title;
            break;
        case 'author':
          $work = get_post($post_id);
          echo '<a href="' . get_admin_url(null, 'user-edit.php?user_id=' . $work->post_author) . '">' . get_user_by('ID', $work->post_author)->display_name . '</a>';
          break;
        case 'campus_image_exam' :
            $campus_id=get_post_meta($post_id,'campus_id',true);
            $status=get_post_meta($post_id,'picture_exam',true);
            if($status=='pass')
            {
                echo '<a href="/campus_image_exam/?campus_id=' . ($post_id) . '&fail='.$post_id.'&destination='. home_url(add_query_arg(array())).'" target="_blank">改为不通过</a>';
            }
            else if($status=='failed')
            {
                echo '<a href="/campus_image_exam/?campus_id=' . ($post_id) . '&pass=' . $post_id . '&destination=' . home_url(add_query_arg(array())) . '" target="_blank">改为通过</a>';
            }
            else {
                echo '<a href="/campus_image_exam/?campus_id=' . ($post_id) . '&pass=' . $post_id . '&destination=' . home_url(add_query_arg(array())) . '" target="_blank"> 通过</a>&nbsp;';
                echo '<a href="/campus_image_exam/?campus_id=' . ($post_id) . '&fail=' . $post_id . '&destination=' . home_url(add_query_arg(array())) . '" target="_blank">不通过</a>';
            }
            break;
        case 'auditing' :
            $campus_id=get_post_meta($post_id,'campus_id',true);
            $status=get_post_meta($post_id,'status',true);
            if($status=='pass')
            {
                echo '<a href="/campus-auditing/?campus_id=' . ($post_id) . '&fail='.$post_id.'&destination='. home_url(add_query_arg(array())).'" target="_blank">改为不通过</a>';
            }
            else if($status=='failed')
            {
                echo '<a href="/campus-auditing/?campus_id=' . ($post_id) . '&pass=' . $post_id . '&destination=' . home_url(add_query_arg(array())) . '" target="_blank">改为通过</a>';
            }
            else {
                echo '<a href="/campus-auditing/?campus_id=' . ($post_id) . '&pass=' . $post_id . '&destination=' . home_url(add_query_arg(array())) . '" target="_blank"> 通过</a>';
                echo '<a href="/campus-auditing/?campus_id=' . ($post_id) . '&fail=' . $post_id . '&destination=' . home_url(add_query_arg(array())) . '" target="_blank">不通过</a>';
            }
            break;
        case 'apply_count':
            $uid=get_post($post_id)->post_author;
            $applyed=get_posts(array(
                    'post_type'=>'campus_apply',
                    'author'=>$uid,
                'numberposts'=>'100000'
            ));
            echo '<a href="edit.php?post_type=campus_apply&uid='.$uid.'">'.count($applyed).'</a>';
            break;
        case 'apply_score':
            $score=0;
            $times=0;
            $uid=get_post($post_id)->post_author;
            $applyed=get_posts(array(
                'post_type'=>'campus_apply',
                'author'=>$uid,
                'numberposts'=>'100000'
            ));
            foreach ($applyed as $v){
                if($vscore=get_post_meta($v->ID,'score',true)){
                    $score+=$vscore;
                    $times++;
                }
            }
            $score/=$times;
            echo $score;
            break;
        case 'status' :

            echo get_post_meta($post_id,'status',true);
            break;
        case 'campus_image_status' :

            echo get_post_meta($post_id,'picture_exam',true);
            break;
        case 'download':

            if(get_post_meta($post_id,'picture_exam',true))
                 echo  '<a href="'.get_the_permalink($post_id).'?download=true">下载</a>';
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
  if (isset($_GET['attend_event_review'])) {
    array_insert($column, 'role', array('resume' => __( '简历和作品', 'young-bird')));
    array_insert($column, 'role', array('review' => __( '审核', 'young-bird')));
    unset($column['role']);
    unset($column['registered']);
  }
  if (isset($_GET['attend_events'])) {
    array_insert($column, 'registered', array('attend_event_date' => __( '参赛时间', 'young-bird')));
    unset($column['registered']);
  }
  if (isset($_GET['attend_activities'])) {
    array_insert($column, 'registered', array('attend_activity_date' => __( '报名时间', 'young-bird')));
    unset($column['registered']);
  }
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
      break;
    case 'works' :
      return '<a href="' . get_admin_url(null, 'edit.php?post_type=work&author=' . $user_id) . '">' . count(get_posts(array('post_type' => 'work', 'lang' => '', 'author' => $user_id, 'posts_per_page' => -1))) . '</a>';
      break;
    case 'resume' :
      return implode('<br>', array_map(function ($resume) { return '<a href="' . $resume . '" target="_blank">' . basename($resume) . '</a>'; }, get_user_meta($user_id, 'resume')));
      break;
    case 'review' :
      return '<input type="hidden" name="attended" value="' . in_array($_GET['attend_event_review'], get_user_meta($user_id, 'attend_events') ?: array()) . '">';
      break;
    case 'attend_event_date':
      $work = get_event_work($_GET['attend_events'], $user_id);
      return $work->post_date;
    case 'attend_activity_date':
      return get_user_meta($user_id, 'attend_activity_date_' . $_GET['attend_activities'], true);
    default:
  }
  return $val;
}, 10, 3 );


add_action('admin_footer', function () {
    $screen = get_current_screen();


    if ( $screen->id != "edit-campus_apply" )   // Only add to users.php page
        return;

    ?>
    <script type="text/javascript">
        jQuery(document).ready( function($)
        {
            $('.tablenav.top .clear, .tablenav.bottom .clear').before('<form method="POST"><input type="hidden" id="ybp_export_campus" name="ybp_export_campus" value="1" /><input class="button user_export_button" style="margin-top:3px;" type="submit" value="<?=__('导出站长', 'young-bird')?>" /></form>');
        });
    </script>
    <?php if (isset($_GET['attend_event_review'])): ?>
        <script type="text/javascript">
            jQuery(document).ready( function($) {
                $('.review.column-review').each(function () {
                    var userId = $(this).parent().attr('id').replace('user-', '');
                    if ($(this).find('[name="attended"]').val()) {
                        $(this).append('<span>已通过</span>');
                    } else {
                        $(this).append('<form method="POST"><input type="hidden" name="user_id" value="' + userId + '"><input class="button" name="ybp_attend_event_agree" type="submit" value="通过"> <input class="button" type="submit" name="ybp_attend_event_disagree" value="否决"></form>');
                    }
                });
            });
        </script>
    <?php endif;
});


add_action('admin_footer', function () {
    $screen = get_current_screen();


    if ( $screen->id != "edit-qa" )   // Only add to users.php page
        return;

    ?>
    <script type="text/javascript">
        jQuery(document).ready( function($)
        {
            $('.tablenav.top .clear, .tablenav.bottom .clear').before('<form method="POST"><input type="hidden" id="ybp_export_qa" name="ybp_export_qa" value="1" /><input class="button user_export_button" style="margin-top:3px;" type="submit" value="<?=__('导出答疑', 'young-bird')?>" /></form>');
        });
    </script>
    <?php if (isset($_GET['attend_event_review'])): ?>
        <script type="text/javascript">
            jQuery(document).ready( function($) {
                $('.review.column-review').each(function () {
                    var userId = $(this).parent().attr('id').replace('user-', '');
                    if ($(this).find('[name="attended"]').val()) {
                        $(this).append('<span>已通过</span>');
                    } else {
                        $(this).append('<form method="POST"><input type="hidden" name="user_id" value="' + userId + '"><input class="button" name="ybp_attend_event_agree" type="submit" value="通过"> <input class="button" type="submit" name="ybp_attend_event_disagree" value="否决"></form>');
                    }
                });
            });
        </script>
    <?php endif;
});

add_action('admin_footer', function () {
    $screen = get_current_screen();


    if ( $screen->id != "users" )   // Only add to users.php page
        return;

    ?>
    <script type="text/javascript">
        jQuery(document).ready( function($)
        {
            $('.tablenav.top .clear, .tablenav.bottom .clear').before('<form method="POST"><input type="hidden" id="ybp_export_users" name="ybp_export_users" value="1" /><input class="button user_export_button" style="margin-top:3px;" type="submit" value="<?=__('导出选手', 'young-bird')?>" /></form>');
        });
    </script>
    <?php if (isset($_GET['attend_event_review'])): ?>
        <script type="text/javascript">
            jQuery(document).ready( function($) {
                $('.review.column-review').each(function () {
                    var userId = $(this).parent().attr('id').replace('user-', '');
                    if ($(this).find('[name="attended"]').val()) {
                        $(this).append('<span>已通过</span>');
                    } else {
                        $(this).append('<form method="POST"><input type="hidden" name="user_id" value="' + userId + '"><input class="button" name="ybp_attend_event_agree" type="submit" value="通过"> <input class="button" type="submit" name="ybp_attend_event_disagree" value="否决"></form>');
                    }
                });
            });
        </script>
    <?php endif;
});

add_action('admin_init', function () {

    if (!empty($_POST['ybp_export_campus']) && current_user_can('manage_options')) {
        // export users in xlsx file
        $data = array();

        foreach ($posts = get_posts(array('post_type' => 'campus_apply','numberposts'=>'100000')) as $post) {
            $user=get_user_by('ID',$post->post_author);
            $schools=get_post_meta($post->ID,'school_id')[0];

            $string='';
            foreach($schools as $v)
            {

                    $school=get_post($v);

                    $string.=$school->post_title.',';
            }

            $string=mb_substr($string,0,mb_strlen($string)-1);
            $campus=get_post_meta($post->ID,'campus_id',true);
            $campus=get_post($campus)->post_title;

            $row = array(
                get_user_meta($user->ID, 'name', true) ?: $user->display_name,
                get_user_meta($user->ID, 'phone', true),
                $user->user_email,
                get_user_meta($user->ID, 'id_card', true),
                get_user_meta($user->ID, 'identity', true),

                get_user_meta($user->ID, 'country', true),
                get_user_meta($user->ID, 'city', true),
                get_user_meta($user->ID, 'school', true),
                get_user_meta($user->ID, 'major', true),

                get_user_meta($user->ID, 'address', true),
                get_user_meta($user->ID, 'company', true),
                get_user_meta($user->ID, 'department', true),
                get_user_meta($user->ID, 'title', true),
                get_user_meta($user->ID,'bank',true),
                get_user_meta($user->ID,'bankcard',true),
                get_post_meta($post->ID,'status',true),
                $string,
                $campus

            );


            $data[] = $row;
        }

        $writer = new XLSXWriter();
        $head = array('姓名' => '@', '手机' => '@', '邮箱' => '@', '证件' => '@', '身份' => '@',  '国家' => '@', '城市' => '@', '学校' => '@', '专业' => '@','地址' => '@', '公司' => '@', '部门' => '@', '职位' => '@', '银行' => '@', '银行卡号' => '@','状态'=>'@','报名学校'=>'@','报名竞赛'=>'@');
        if (isset($event)) {
            $head = array_merge($head, array('团队名称' => '@', '作品编号' => '@', '参赛时间' => '@'));
        }
        $writer->writeSheetHeader('选手', $head);
        foreach ($data as $row) {
            $writer->writeSheetRow('选手', $row);
        }

        $filename = __(isset($event) ? ('站长' . $event->post_title) : '所有站长', 'young-bird') . '.xlsx';
        $path = wp_upload_dir()['path']  . '/' . $filename;
        $writer->writeToFile($path);
        header('Content-Disposition: attachment; filename=' . $filename );
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Length: ' . filesize($path));
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        readfile($path); unlink($path); exit;
    }



    if (!empty($_POST['ybp_export_qa']) && current_user_can('manage_options')) {
        // export users in xlsx file
        $data = array();
        $arg=array('post_type' => 'qa', 'posts_per_page' => -1);
        if(isset($_GET['event_id'])){
            $event=get_post($_GET['event_id']);
            $arg['meta_key']='event_id';
            $arg['meta_value']=$event->ID;

        }
        $arg['post_status'] ='pending';
        $posts = get_posts($arg);


        foreach ( $posts as $post) {


            $row = array(
                get_post_meta($post->ID,'name',true),

                get_post_meta($post->ID,'phone',true),
                get_post_meta($post->ID,'mail',true),
                get_post_meta($post->ID,'question',true),
                get_post_meta($post->ID,'answer',true),
                get_post(get_post_meta($post->ID,'event_id',true))->post_title,

            );


            $data[] = $row;
        }

        $writer = new XLSXWriter();
        $head = array('姓名' => '@', '手机' => '@', '邮箱' => '@', '问题'=>'@','回答'=>'@','竞赛'=>'@');

        $writer->writeSheetHeader('qa', $head);
        foreach ($data as $row) {
            $writer->writeSheetRow('qa', $row);
        }

        $filename = __(isset($event) ? ('qa' . $event->post_title) : 'qa', 'young-bird') . '.xlsx';
        $path = wp_upload_dir()['path']  . '/' . $filename;
        $writer->writeToFile($path);
        header('Content-Disposition: attachment; filename=' . $filename );
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Length: ' . filesize($path));
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        readfile($path); unlink($path); exit;
    }
  if (!empty($_POST['ybp_export_users']) && current_user_can('manage_options')) {
    // export users in xlsx file
    $data = array();

    foreach ($users = get_users(array('role' => 'attendee')) as $user) {
      $row = array(
        get_user_meta($user->ID, 'name', true) ?: $user->display_name,
        get_user_meta($user->ID, 'mobile', true),
        $user->user_email,
        get_user_meta($user->ID, 'id_card', true),
        get_user_meta($user->ID, 'identity', true),
        get_user_meta($user->ID, 'sex', true),
        get_user_meta($user->ID, 'birthday', true),
        get_user_meta($user->ID, 'country', true),
        get_user_meta($user->ID, 'city', true),
        get_user_meta($user->ID, 'school', true),
        get_user_meta($user->ID, 'major', true),
        get_user_meta($user->ID, 'constellation', true),
        get_user_meta($user->ID, 'hobby', true),
        get_user_meta($user->ID, 'address', true),
        get_user_meta($user->ID, 'company', true),
        get_user_meta($user->ID, 'department', true),
        get_user_meta($user->ID, 'title', true),
        date('Y-m-d H:i:s', strtotime($user->user_registered) + get_option('gmt_offset') * HOUR_IN_SECONDS)
      );

      if (isset($_GET['attend_events'])) {
        $event = get_post($_GET['attend_events']);
        $group = get_event_group($event->ID, $user->ID);
        $work = get_event_work($event->ID, $user->ID);
        $row[] = $group->post_title;
        $row[] = 'YB' . strtoupper($work->post_name);
        $row[] = $work->post_date;
      }

      $data[] = $row;
    }

    $writer = new XLSXWriter();
    $head = array('姓名' => '@', '手机' => '@', '邮箱' => '@', '证件' => '@', '身份' => '@', '性别' => '@', '生日' => '@', '国家' => '@', '城市' => '@', '学校' => '@', '专业' => '@', '星座' => '@', '兴趣' => '@', '地址' => '@', '公司' => '@', '部门' => '@', '职位' => '@', '注册时间' => 'YYYY-MM-DD HH:MM:SS');
    if (isset($event)) {
      $head = array_merge($head, array('团队名称' => '@', '作品编号' => '@', '参赛时间' => '@'));
    }
    $writer->writeSheetHeader('选手', $head);
    foreach ($data as $row) {
      $writer->writeSheetRow('选手', $row);
    }

    $filename = __(isset($event) ? ('选手 ' . $event->post_title) : '所有选手', 'young-bird') . '.xlsx';
    $path = wp_upload_dir()['path']  . '/' . $filename;
    $writer->writeToFile($path);
    header('Content-Disposition: attachment; filename=' . $filename );
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Length: ' . filesize($path));
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    readfile($path); unlink($path); exit;
  }

  if (!empty($_POST['ybp_attend_event_agree']) || !empty($_POST['ybp_attend_event_disagree'])) {
    $event_id = $_GET['attend_event_review'];
    $user_id = $_POST['user_id'];
    $event_name = get_post(pll_get_post($event_id))->post_title;
    if (isset($_POST['ybp_attend_event_agree'])) {
      try {
        add_post_meta($event_id, 'attend_users', $user_id);
        add_user_meta($user_id, 'attend_events', $event_id);
      } catch (Exception $e) {
        // 对于重复添加meta造成的数据库错误保持静默
      }
      $work = get_event_work($event_id, $user_id, null, true);
      send_message($user_id, 'event-review-agreed', array('event' => $event_name, 'no' => 'YB' . strtoupper($work->post_name)));
    } else {
      delete_user_meta($user_id, 'attend_event_review', $event_id);
      send_message($user_id, 'event-review-disagreed', array('event' => $event_name));
    }
  }
});

add_action('admin_footer', function () {
  $screen = get_current_screen();
  if ( $screen->id != "edit-work" || empty($_GET['event_id']))   // Only add to users.php page
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
    $event = get_post($_GET['event_id']);

    $data = array();

    $works = get_posts(array('post_type' => 'work', 'lang' => '', 'posts_per_page' => -1, 'meta_key' => 'event', 'meta_value' => pll_get_post($_GET['event_id'], pll_default_language())));

    foreach ($works as $work) {

      // compile authors string
      $group_id = get_post_meta($work->ID, 'group', true);
      if ($group_id) {
        $group = get_post($group_id);
        $authors = $group->post_title . ': ';
        $member_ids = get_post_meta($group->ID, 'members');
        foreach ($member_ids as $member_id) {
          $authors .= get_user_by('ID', $member_id)->display_name;
        }
      } else {
        $authors =  get_user_by('ID', $work->post_author)->display_name;
      }

      $judge_score = get_post_meta($work->ID, 'score', true) ?: 0;
      $votes = get_post_meta($work->ID, 'votes', true) ?: 0;

      // get votes, votes of same event
      $event_id = get_post_meta($work->ID, 'event', true);
      $vote_weight = get_post_meta($event->ID, 'vote_weight', true) ?: 10;

      global $wpdb;
      $max_votes = $wpdb->get_var("select max(cast(meta_value as unsigned)) from {$wpdb->postmeta} where meta_key = 'votes' and post_id in (select post_id from {$wpdb->postmeta} where meta_value = '{$event_id}' and meta_key = 'event')");
      $vote_score = $max_votes ? ($votes / $max_votes * $vote_weight) : 0;
      $score = $judge_score + $vote_score;
      $pass_status = get_post_meta($work->ID, 'status', true) ? __('入围', 'young-bird') : __('未入围', 'young-bird');

      $row = array(
        $work->post_title,
        'YB' . strtoupper($work->post_name),
        count(get_post_meta($work->ID, 'images')),
        $authors,
        $pass_status,
        $judge_score,
        $votes,
        $score,
        get_the_date('Y-m-d H:i:s', $work->ID)
      );

      $data[] = $row;
    }

    $writer = new XLSXWriter();
    $filename = '作品 - ' . $event->post_title . '.xlsx';
    $path = wp_upload_dir()['path']  . '/' . $filename;
    $writer->writeSheetHeader('作品', array('名称' => '@', '编号' => '@', '图片' => '@', '选手' => '@', '状态' => '@', '大咖评分' => '@', '大众投票' => '@', '总分' => '@', '日期' => 'YYYY-MM-DD HH:MM:SS'));
    foreach ($data as $row) {
      $writer->writeSheetRow('作品', $row);
    }
    $writer->writeToFile($path);
    header('Content-Disposition: attachment; filename=' . $filename );
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Length: ' . filesize($path));
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    readfile($path); unlink($path); exit;
  }
});


function publish_qaa( $post_id ) {

    // If this is just a revision, don't send the email.
   $post=get_post($post_id);
   if($post->post_type!='qaa')
   {
       return;
   }
    $post->post_status='post_status';
   // wp_update_post($post);

    // Send email to admin.

}
add_action( 'save_post', 'publish_qaa' );