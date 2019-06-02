<?php




if (isset($_GET['participate'])) {
  redirect_login();
}
$dayi=false;

try {

$id_dl = pll_get_post(get_the_ID(), pll_default_language());

$dayi=get_post_meta($id_dl,'ext_attend_link',true);
if(!$dayi){
    $dayi=true;
}


    $cansairenshu=get_users(array(
            'role'=>'attendee',
            'meta_key'=>'attend_events',
            'meta_value'=>$id_dl)

    );

$cansairenshu=count($cansairenshu);
   /* $crank=get_posts(array(
        'post_type'=>'rank',
        'meta_key'=>'event',
        'meta_value'=>$id_dl
    ));
    if(!empty($crank))
        $dayi=true;*/
$like_events = get_user_meta(get_current_user_id(), 'like_events') ?: array();
$views = (get_post_meta($id_dl, 'views', true) ?: 0) + 1;
update_post_meta($id_dl, 'views', $views);

if (isset($_POST['like'])) {
  redirect_login();
  $like = json_decode($_POST['like']);
  if ($like && !in_array($id_dl, $like_events)) {
    add_user_meta(get_current_user_id(), 'like_events', $id_dl);
  }
  elseif (!$like && in_array($id_dl, $like_events)) {
    delete_user_meta(get_current_user_id(), 'like_events', $id_dl);
  }
  exit;
}

if (isset($_POST['remind_event_ending'])) {
  redirect_login();
  $days_left = ceil((strtotime(get_field('end_date')) - get_option('gmt_offset') * HOUR_IN_SECONDS - time()) / 86400);
  $attended_user_ids = $wpdb->get_col("select user_id from {$wpdb->usermeta} where meta_key = 'attend_events' and meta_value = '" . $id_dl . "'");
  if ($days_left <= 10) {
    $template = 'the-deadline-for-submissions';
  } elseif ($days_left <= 30) {
    $template = 'the-competition-is-closing';
  } else {
    $template = 'the-midway-point-of-the-competition';
  }
  foreach ($attended_user_ids as $attended_user_id) {
    send_message($attended_user_id, $template, array('competition' => get_the_title()));
  }
  exit;
}

if (isset($_POST['generate_certs']) || isset($_GET['test_generate_certs'])) {
  redirect_login();
  ignore_user_abort(); set_time_limit(0);
  $cert_ranks = get_posts(array('post_type' => 'rank', 'meta_query' => array(
    array('key' => 'event', 'value' => $id_dl),
    array('key' => 'create_cert', 'value' => '1')
  )));
  $cert_rank_ids = array_column($cert_ranks, 'ID');
  $event = get_post($id_dl);
  $event_en = get_post(pll_get_post($id_dl, 'en'));
  $honor_works = get_posts(array('post_type' => 'work', 'lang' => '', 'posts_per_page' => -1, 'meta_key' => 'rank', 'meta_compare' => 'IN', 'meta_value' => $cert_rank_ids));
  $participate_works = get_posts(array('post_type' => 'work', 'posts_per_page' => -1, 'lang' => '', 'meta_query' => array(
    array('key' => 'event', 'value' => $id_dl),
    array('key' => 'status', 'value' => '1')
  )));
  $cert_template_honor = get_post_meta($id_dl, 'cert_template_honor', true);
  $cert_template_participation = get_post_meta($id_dl, 'cert_template_participation', true);
  $cert_template_honor_path = get_attached_file($cert_template_honor);
  $cert_template_participation_path = get_attached_file($cert_template_participation);

  foreach ($honor_works as $work) {
    // generate honor cert
    $work_rank_ids = get_post_meta($work->ID, 'rank');
    $work_final_rank_id = $work_rank_ids[count($work_rank_ids)-1];
    $rank_length = get_post_meta($work_final_rank_id, 'length', true);
    $rank_is_participate_round = get_field('is_participate_round', $work_final_rank_id);

    $group_id = get_post_meta($work->ID, 'group', true);
    if ($group_id) {
      $member_ids = get_post_meta($group_id, 'members');
      $issue_to = 'TEAM ' . get_post($group_id)->post_title . "\n";
      foreach ($member_ids as $i => $member_id) {
        $member = get_user_by('ID', $member_id);
        $member_name = $member->display_name;

        $lines = explode("\n", $issue_to);
        $last_line = $lines[count($lines)-1];
        if (mb_strlen($last_line) + mb_strlen($member_name) > 40) {
          $issue_to .= "\n";
        } else if ($i) {
          $issue_to .= ',  ';
        }
        $issue_to .= $member_name;
      }
    } else {
      $author = get_user_by('ID', $work->post_author);
      $issue_to = $author->display_name;
    }

    $honor_type = $rank_is_participate_round ? 'participate' : 'award';

    if ($honor_type === 'award') {
      $cert_honor_filename = generate_certificate_honor($issue_to, 'YB' . strtoupper($work->post_name), $work->post_title, $rank_length, $event->post_title, $event_en->post_title, $cert_template_honor_path);
    } else {
      $from = mb_strtoupper(get_user_meta($work->post_author, 'school', true) ?: get_user_meta($work->post_author, 'company', true));
      $cert_honor_filename = generate_certificate_participate($issue_to, 'YB' . strtoupper($work->post_name), $from, get_post_meta($id_dl,'start_date',true), $event_en->post_title, $cert_template_participation_path);
    }
    update_post_meta($work->ID, 'cert_honor', wp_upload_dir()['url'] . '/' . $cert_honor_filename);

    if ($group_id) {
      $member_ids = get_post_meta($group_id, 'members');
      foreach ($member_ids as $member_id) {
        send_message($member_id, 'certificate-of-' . $honor_type, array('competition' => $event->post_title));
      }
    } else {
      send_message($work->post_author, 'certificate-of-' . $honor_type, array('competition' => $event->post_title));
    }
  }

  exit;
}

the_post();

$user = wp_get_current_user();

$attended = in_array($id_dl, get_user_meta($user->ID, 'attend_events') ?: array ());

$participate_fields = ['name', 'sex', 'identity', 'id_card', 'birthday', 'school', 'major', 'country', 'city', 'company', 'department', 'title'];
foreach ($participate_fields as $field) {
  $$field =  get_user_meta($user->ID, $field, true);
}

if (isset($_POST['participate'])) {
  redirect_login();
  if($_POST['participate']=='step-3')
  {

      $event_post=get_post($id_dl);

     // if(isset($_POST['']))

      if(isset($_POST['ybp_collect']))
      {

          $rpostid=0;
          $term=$_POST['ybp_collect'];
          $rargss = array('author'=>get_current_user_id(), 'post_type' => 'user_source_post');
          $rmypostss = get_posts( $rargss );

          foreach($rmypostss as $vr){

              if(get_post_meta($vr->ID)['event_id'][0]==$id_dl)
              {
                  wp_delete_post($vr->ID);

              };

          }



          $termdata=array();
          $post_content=$event_post->post_title;
          foreach($term as $v){
              $termdata[]=get_term($v,'user_source')->slug;
              $post_content.='-'.get_term($v,'user_source')->name;
          }

          if(in_array('0',$_POST['ybp_collect'])){
              $termdata[]='others';
          }

              $my_post = array(
                  'post_title'    =>$post_content,
                  'post_type'=>'user_source_post',
                  'post_content'  =>$_POST['ybp_other'],
                  'post_status'   => 'publish',
                  'post_author'   => get_current_user_id(),
                  'meta_input'=>array('event_id'=>$id_dl),
              );
              $my_post=wp_insert_post( $my_post, $wp_error );



          wp_set_object_terms($my_post,$termdata,'user_source');
         // wp_set_post_terms($id_dl,$termdata,'user_source');


      }
      else {

          header('Location: ' . get_the_permalink() . '?participate=step-25' ); exit;
      }


   //    if($_POST)
  }
  else {
      foreach ($participate_fields as $field) {
          if (isset($_POST[$field])) {
              update_user_meta($user->ID, $field, $_POST[$field]);
          }
      }
      if ($_POST['name']) {
          $user->display_name = $_POST['name'];
      }
      if ($_POST['email']) {
          $user->user_email = $_POST['email'];
      }

      if ($_POST['name'] || $_POST['email']) {
          wp_update_user($user);
      }


  }
    $next_step = $_POST['participate'];

    if ($_POST['identity'] === 'studying') {
        $next_step = 'step-25';
    }
  header('Location: ' . get_the_permalink() . '?participate=' . $next_step); exit;
}

if (isset($_POST['create_group'])) {
  redirect_login();
  $groups = get_posts(array (
    'post_type' => 'group',
    'lang' => '',
    'title' => htmlspecialchars_decode($_POST['group_name_create']),
    'meta_key' => 'event',
    'meta_value' => $id_dl
  ));

  if ($groups) {
    throw new Exception(__('已经存在同名团队', 'young-bird'));
  }

  $group_id = wp_insert_post(array (
    'post_type' => 'group',
    'post_title' => htmlspecialchars_decode($_POST['group_name_create']),
    'post_status' => 'publish'
  ));
  add_post_meta($group_id, 'event', $id_dl);
  add_post_meta($group_id, 'members', $user->ID);
  add_user_meta($user->ID, 'attend_events_captain', $id_dl);
  header('Location: ' . get_the_permalink() . '?participate=step-4'); exit;
}

if (isset($_POST['join_group'])) {
  redirect_login();
   $group_name= htmlspecialchars_decode($_POST['group_name_join']);
   //$group_name=str_replace('&','&amp;',$group_name);

  $groups = get_posts(array (
    'post_type' => 'group',
    'lang' => '',
    'title' => $group_name,
    'meta_key' => 'event',
    'meta_value' => $id_dl
  ));
  
  if (!$groups || count($groups) > 1) {
    throw new Exception(__('没有找到这个团队', 'young-bird'));
  }

  $group = $groups[0];

  add_post_meta($group->ID, 'members_pending', $user->ID);
  add_user_meta($user->ID, 'attend_events_member', $id_dl);
  send_message($group->post_author, 'an-application-for-joining-the-team', array('team' => $group->ID));
  header('Location: ' . get_the_permalink() . '?participate=step-4'); exit;
}

if (isset($_GET['participate']) && $_GET['participate'] === 'step-4') {
  redirect_login();
  $attend_events = get_user_meta($user->ID, 'attend_events');
  $work = get_event_work($id_dl, $user->ID, null, true);
  if (!in_array($id_dl, $attend_events)) {
    $attendees = get_post_meta($id_dl, 'attendees', true) ?: 0;
    update_post_meta($id_dl, 'attendees', ++$attendees);
    add_post_meta($id_dl, 'attend_users', $user->ID);

      $campus=get_posts(array(
          'post_type'=>'campus',
          'meta_key'=>'event',
          'meta_value'=>$id_dl
      ));
      if($campus){
          $campus=$campus[0];
          $school=get_user_meta(get_current_user_id(),'school',true);

          $school=get_posts(array(
              'post_type'=>'campus_school',
              'meta_key'=>'school_name',
              'meta_value'=>$school
          ));
          if($school) {
              $school = $school[0];

              $school=pll_get_post($school->ID,pll_default_language());

              $campusimage = get_posts(array(
                  'post_type' => 'campusimage',
                  'meta_query' => array(
                      array('key' => 'campus_id', 'value' => $campus->ID),
                      array('key' => 'school_id', 'value' => $school)
                  )
              ));
              $campusimage=$campusimage[0];
              $hascount=get_post_meta($campusimage->ID,'campus_register');
              if(!in_array($id_dl,$hascount)){
                  add_post_meta($campusimage->ID,'campus_register',$id_dl);
                  $amontcount=get_post_meta($campusimage->ID,'campus_register_count',true);
                  if(!$amontcount)
                  {
                      $amontcount=1;
                      add_post_meta($campusimage->ID,'campus_register_count',1);
                  }
                  else{
                      $amontcount++;
                      update_post_meta($campusimage->ID,'campus_register_count',$amontcount);
                  }
              }

          }
      }

    add_user_meta($user->ID, 'attend_events', $id_dl);

    // 以个人名义参赛
    if (isset($_GET['single'])) {
      add_user_meta($user->ID, 'attend_events_solo', $id_dl);
    }
    send_message($user->ID, 'successfully-applied-for-this-competition', array('no' => 'YB' . strtoupper($work->post_name)));
  }
}

} catch (Exception $e) {
  $form_error = $e->getMessage();
}

$group = get_event_group($id_dl, $user->ID);

if ($group) {
  $im_leader = $group->post_author == $user->ID;
} elseif ($user->ID) {
  $work = get_posts(array ('post_type' =>'work', 'lang' => '', 'author' => $user->ID, 'meta_key' => 'event', 'meta_value' => $id_dl))[0];
}

get_header();

if (isset($_GET['participate'])):
  redirect_login();
  $step = $_GET['participate'] ?: 'step-1';
  $user = wp_get_current_user();
  $attend_events = get_user_meta($user->ID, 'attend_events');
  if (in_array($id_dl, $attend_events) && $step !== 'step-4') {
    header('Location: ' . get_the_permalink() . '?participate=step-4'); exit;
  }

  include(locate_template('single-event-participate-' . $step . '.php'));
else:
?>
    <!-- Body -->
    <div class="container page-event-detail pb-4">
      <div class="sidebar">
        <ul>
          <li class="d-none d-lg-block">
            <a class="text-truncate" href="#section1" title="<?=__('竞赛介绍', 'young-bird')?>"><?=__('竞赛介绍', 'young-bird')?></a>
          </li>
          <?php if (get_field('attend_review') && !$attended): ?>
          <?php if (in_array(get_post_meta($id_dl, 'status', true), array('started', 'ending'))):
              if (!in_array($id_dl, get_user_meta(get_current_user_id(), 'attend_event_review') ?: array())): ?>
              <li class="d-lg-block">

                <a class="text-truncate" href="<?=pll_home_url()?>user-center/?attend-review=<?=$id_dl?>"><?=__('申请报名', 'young-bird')?></a>
              </li>
              <?php else: ?>
              <li class="d-lg-block">
                <a href="javascript:return false" class="disabled"><?=__('报名审核中', 'young-bird')?></a>
              </li>
              <?php
              endif;
            endif; ?>

          <?php else: ?>
          <li class="d-none d-lg-block">
            <a class="text-truncate" href="#section2" title="<?=__('奖项设置', 'young-bird')?>"><?=__('奖项设置', 'young-bird')?></a>
          </li>
          <?php if ($judges = get_field('judges')): ?>
          <li class="d-none d-lg-block">
            <a class="text-truncate" href="#section3" title="<?=__('评委介绍', 'young-bird')?>"><?=__('评委介绍', 'young-bird')?></a>
          </li>
          <?php endif; ?>
          <?php if ($qa = get_field('q&a')): ?>
          <li class="d-none d-lg-block">
            <a class="text-truncate" href="#section4">Q&A</a>
          </li>
          <?php endif; ?>
              <?php if (!get_post_meta(get_the_ID(), 'ext_attend_link', true)): ?>
            <li class="d-none d-lg-block">
                  <a class="text-truncate" href="<?=pll_home_url();?>/qa?event_id=<?=$id_dl?>"><?=__('提问', 'young-bird')?></a>
            </li>
            <?php endif;?>
          <?php if ($news_ids = get_post_meta($id_dl, 'news', true)): ?>
          <li class="d-none d-lg-block">
            <a class="text-truncate" href="#section5" title="<?=__('相关新闻', 'young-bird')?>"><?=__('相关新闻', 'young-bird')?></a>
          </li>
          <?php endif; ?>
          <?php if ($document = get_field('document')): ?>
          <li class="d-none d-lg-block">
            <a class="text-truncate" href="<?=$document['url']?>" download title="<?=__('下载文件', 'young-bird')?>"><?=__('下载文件', 'young-bird')?></a>
          </li>
          <?php endif; ?>
          <?php foreach (get_posts(array('post_type' => 'rank', 'posts_per_page' => -1, 'meta_key' => 'event', 'meta_value' => get_the_ID())) as $rank): $rank_length =  get_post_meta($rank->ID, 'length', true); ?>
          <li>
            <?php $rank_is_participate_round = get_post_meta($rank->ID, 'is_participate_round', true); $rank_label = $rank_is_participate_round ? __('入围', 'young-bird') : sprintf(__('%s强', 'young-bird'), $rank_length); ?>
            <a class="text-truncate" href="<?=get_the_permalink($rank->ID)?>" title="<?=$rank_label?>"><?=$rank_label?></a>
          </li>
          <?php endforeach; ?>
          <?php if (current_user_can('edit_users') && $cert_template_participation = get_post_meta($id_dl, 'cert_template_participation', true) && $cert_template_honor = get_post_meta($id_dl, 'cert_template_honor', true) && get_field('status') === 'judged'): ?>
          <li class="d-none d-lg-block">
            <a class="text-truncate generate-certs" href="" title="<?=__('生成证书', 'young-bird')?>"><?=__('生成证书', 'young-bird')?></a>
          </li>
          <?php endif; ?>
          <li class="active">
            <?php if (current_user_can('edit_user') && get_field('status') === 'ended'): // 管理员查看已结束竞赛=入围评审 ?>
            <a class="text-truncate d-none d-lg-block" href="<?=pll_home_url()?>work/?event_id=<?=$id_dl?>" title="<?=__('入围评审', 'young-bird')?>"><?=__('入围评审', 'young-bird')?></a>
            <?php elseif (current_user_can('edit_user') && in_array(get_field('status'), array('started', 'ending', 'ended'))): // 管理员查看正在进行行竞赛=催稿 ?>
            <a class="text-truncate d-none d-lg-block remind-event-ending" href="#" data-days-before-end="<?=ceil((strtotime(get_field('end_date')) - get_option('gmt_offset') * HOUR_IN_SECONDS - time()) / 86400)?>" title="<?=__('催稿', 'young-bird')?>"><?=__('催稿', 'young-bird')?></a>
            <?php elseif ($attendable = in_array(get_field('status'), array('started', 'ending')) && !$attended): ?>
            <a class="text-truncate" href="<?=get_post_meta(get_the_ID(), 'ext_attend_link', true) ?: (get_the_permalink() . '?participate')?>" title="<?=__('参赛', 'young-bird')?>"><?=__('参赛', 'young-bird')?></a>
            <?php elseif ($group && $attended_as_member = in_array($id_dl, get_user_meta($user->ID, 'attend_events_member') ?: array())): ?>
            <a class="text-truncate d-none d-lg-block" href="<?=get_the_permalink($group->ID)?>" title="<?=__('查看团队', 'young-bird')?>"><?=__('查看团队', 'young-bird')?></a>
            <?php elseif ($attended && ($group || $work) && in_array(get_field('status'), array('started', 'ending', 'ended'))): ?>
            <a class="text-truncate d-none d-lg-block" href="<?=$group ? get_the_permalink($group->ID) : get_the_permalink($work->ID)?>" title="<?=__('编辑作品', 'young-bird')?>"><?=__('编辑作品', 'young-bird')?></a>
            <?php elseif ($attended && in_array(get_field('status'), array('started', 'ending', 'ended'))): ?>
            <a class="text-truncate d-none d-lg-block" href="<?=get_the_permalink()?>?create-work" title="<?=__('上传作品', 'young-bird')?>"><?=__('上传作品', 'young-bird')?></a>
            <?php endif;?>
          </li>
          <?php if (get_field('status') === 'history' && $gallery = get_post_meta($id_dl, 'gallery', true)): ?>
          <li class="d-none d-lg-block">
            <a class="text-truncate moment-anchor" href="" title="<?=__('精彩瞬间', 'young-bird')?>"><?=__('精彩瞬间', 'young-bird')?></a>
            <div class="d-none">
              <?php foreach ($gallery as $image): ?>
              <a href="<?=$image?>"></a>
              <?php endforeach; ?>
            </div>
          </li>
          <?php endif; ?>
          <?php endif; ?>
        </ul>
      </div>
      <div class="content">
        <section class="header">
          <!-- poster -->
          <div class="poster">
            <img src="<?=get_field('kv')['sizes']['hd']?>">
          </div>
          <!-- title -->
          <div class="title row justify-content-between flex-nowrap align-items-start">
            <div class="col-md-18">
              <h1 class="color-black">
                <?php the_title(); ?>
              </h1>
              <span class="time"><?=get_post_meta(get_the_ID(), 'start_date', true)?> ~ <?=get_post_meta(get_the_ID(), 'end_date', true)?></span>
              <div class="time mt-2">
                <?php if ($views = get_post_meta($id_dl, 'views', true)): ?>
                <i class="far fa-eye mr-1"></i>
                <span class="mr-3"><?=__('查看次数', 'young-bird')?> / <?=$views?></span>
                <?php endif; ?>
                <?php if (!get_post_meta(get_the_ID(), 'ext_attend_link', true)): ?>
                <?php if ($attendees = get_post_meta($id_dl, 'attendees', true)): ?>
                <i class="far fa-user mr-1"></i>
                <span class="mr-3"><?=__('参赛人数', 'young-bird')?> / <?=$cansairenshu?></span>
                <?php endif; ?>
                <?php endif; ?>
                <span class="like-box mr-1">
                  <i class="<?=in_array($id_dl, $like_events) ? 'fas ' : 'far'?> fa-heart like"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="row mx-auto justify-content-between align-items-center mt-3">
            <div>
              <?php if ($terms = get_the_terms(get_the_ID(), 'event_category')): foreach ($terms as $term): ?>
              <i class="tag tag-grey" style="padding:5px 10px; background: <?=get_field('color', $term)?>"><?=$term->name?></i>
              <?php endforeach; endif; ?>
            </div>
            <div class="d-none d-md-flex align-items-center share" style="line-height:0">
              <div class="share-container"></div>
            </div>
          </div>
        </section>
        <div class="context">
          <h2 class="row align-items-center mx-auto" id="section1">
            <!-- <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt=""> -->
            <span><?=__('竞赛介绍', 'young-bird')?></span>
          </h2>
          <div class="editor">
            <?php if (!get_field('attend_review') || $attended): ?>
            <?php the_content(); ?>
            <?php else: ?>
            <?=wpautop(get_field('brief'))?>
            <?php endif; ?>
          </div>
          <?php if (!get_field('attend_review') || $attended): ?>
          <h2 class="row align-items-center mx-auto" id="section2">
            <!-- <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt=""> -->
            <span><?=__('奖项设置', 'young-bird')?></span>
          </h2>
          <div class="editor">
            <?=get_field('awards')?>
          </div>
          <?php if ($judges = get_field('judges')): ?>
          <h2 class="row align-items-center mx-auto" id="section3">
            <!-- <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt=""> -->
            <span><?=__('评委介绍', 'young-bird')?></span>
          </h2>
          <div class="editor judge-list row">
            <?php foreach ($judges as $judge): ?>
            <div class="col-md-12 col-lg-8">
              <a href="<?=get_the_permalink($judge->ID)?>">
                <div class="d-flex flex-nowrap align-items-start py-4">
                  <div class="avatar">
                    <?=get_the_post_thumbnail($judge->ID, 'thumbnail')?>
                  </div>
                  <div class="desc pl-3">
                    <p class="color-black font-weight-bold"><?=get_the_title($judge->ID)?></p>
                    <?php foreach (array_slice(explode("\n", $judge->post_excerpt), 0, 2) as $line): ?>
                    <small class="d-inline-block color-black font-weight-bold text-truncate mb-0"><?=$line?></small>
                    <?php endforeach; ?>
                  </div>
                </div>
              </a>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <?php if ($qa): ?>
          <h2 class="row align-items-center mx-auto" id="section4">
            <!-- <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt=""> -->
            <span>Q&A</span>
          </h2>
          <div class="editor">
            <?=$qa?>
          </div>
          <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="container-fluid bg-bg-light-grey" id="section5">
      <div class="container">
        <div class="owl-carousel related-news owl-theme">
          <?php if ($news_ids): $newses = get_posts(array('post__in' => $news_ids, 'posts_per_page' => -1)); foreach ($newses as $news): $news = get_post($news->ID) ?>
          <div class="item">
            <a href="<?=get_permalink($news->ID)?>" class="card mb-3 item-sub-history">
              <div>
              <?=get_the_post_thumbnail($news->ID, '8-7', array ('class' => 'card-img-top'))?>
              </div>
              <div class="card-label">
                <span class="hashtag"># <?=strip_tags(get_the_tag_list('', '、', '', $news->ID))?></span>
                <div>
                  <?php foreach (get_the_terms($news->ID, 'news_category') ?: array() as $term): ?>
                  <i class="tag tag-grey" style="background: <?=get_field('color', $term)?>"><?=$term->name?></i>
                  <?php endforeach; ?>
                </div>
              </div>
              <hr />
              <div class="card-body">
                <h4 class="text-truncate"><?=get_the_title($news->ID)?></h4>
                <p class="text-truncate"><?=get_the_subtitle($news->ID)?></p>
                <p><?=$news->post_excerpt?></p>
              </div>
            </a>
          </div>
          <?php endforeach; endif; ?>
        </div>
      </div>
    </div>
    <a class="scroll-to-top-btn" href="#" style="display: none"><i class="fas fa-chevron-up"></i><br>TOP</a>
<?php endif; get_footer(); ?>
