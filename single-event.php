<?php
if (isset($_GET['participate'])) {
  redirect_login();
}

if (isset($_POST['like'])) {
  redirect_login();
  if (json_decode($_POST['like'])) {
    add_user_meta(get_current_user_id(), 'like_events', get_the_ID());
  }
  else {
    delete_user_meta(get_current_user_id(), 'like_events', get_the_ID());
  }
  exit;
}

if (isset($_POST['remind_event_ending'])) {
  $days_left = ceil((strtotime(get_field('end_date')) - time()) / 86400);
  $attended_user_ids = $wpdb->get_col("select user_id from {$wpdb->usermeta} where meta_key = 'attend_events' and meta_value = '" . get_the_ID() . "'");
  if ($days_left < 3) {
    $template = 'the-deadline-for-submissions';
  } elseif ($days_left < 7) {
    $template = 'the-competition-is-closing';
  } elseif ($days_left < 30) {
    $template = 'the-midway-point-of-the-competition';
  }
  foreach ($attended_user_ids as $attended_user_id) {
    send_message($attended_user_id, $template, array('competition' => get_the_title()));
  }
  exit;
}

the_post();

$user = wp_get_current_user();

$participate_fields = ['name', 'identity', 'id_card', 'birthday', 'school', 'major', 'country', 'city', 'company', 'department', 'title'];
foreach ($participate_fields as $field) {
  $$field =  get_user_meta($user->ID, $field, true);
}

if (isset($_POST['participate'])) {
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

  $next_step = $_POST['participate'];

  if ($_POST['identity'] === 'studying') {
    $next_step = 'step-3';
  }

  header('Location: ' . get_the_permalink() . '?participate=' . $next_step); exit;
}

if (isset($_POST['create_group'])) {
  $groups = get_posts(array (
    'post_type' => 'group',
    'title' => $_POST['group_name_create'],
    'meta_key' => 'event',
    'meta_value' => get_the_ID()
  ));

  if ($groups) {
    exit('Group name exists.');
  }

  $group_id = wp_insert_post(array (
    'post_type' => 'group',
    'post_title' => $_POST['group_name_create'],
    'post_status' => 'publish'
  ));
  add_post_meta($group_id, 'event', get_the_ID());
  add_post_meta($group_id, 'members', $user->ID);
  add_user_meta($user->ID, 'attend_events_captain', get_the_ID());
  $attendees = get_post_meta(get_the_ID(), 'attendees', true) ?: 0;
  update_post_meta(get_the_ID(), 'attendees', ++$attendees);
  header('Location: ' . get_the_permalink() . '?participate=step-4'); exit;
}

if (isset($_POST['join_group'])) {
  $group = get_posts(array (
    'post_type' => 'group',
    'title' => $_POST['group_name_join'],
    'meta_key' => 'event',
    'meta_value' => get_the_ID()
  ))[0];
  if (!$group) {
    exit('Group not found.');
  }
  update_post_meta($group->ID, 'members_pending', $user->ID);
  add_user_meta($user->ID, 'attend_events_member', get_the_ID());
  send_message($group->post_author, 'an-application-for-joining-the-team');
  header('Location: ' . get_the_permalink() . '?participate=step-4'); exit;
}

if (isset($_GET['participate']) && $_GET['participate'] === 'step-4') {
  // TODO 重复访问本页会导致重复发送消息和添加meta信息
  add_post_meta(get_the_ID(), 'attend_users', $user->ID);
  add_user_meta($user->ID, 'attend_events', get_the_ID());
  send_message($user->ID, 'successfully-applied-for-this-competition');
}

// 以个人名义参赛
if (isset($_GET['create-work'])) {
  $event_id = get_the_ID();
  $attendees = get_post_meta(get_the_ID(), 'attendees', true) ?: 0;
  $work_id = wp_insert_post(array (
    'post_type' => 'work',
    'post_status' => 'publish',
    'post_title' => __('新作品', 'young-bird'),
    'post_name' => $event_id . '-s' . $user->ID
  ));
  add_post_meta($work_id, 'event', $event_id);
  update_post_meta(get_the_ID(), 'attendees', ++$attendees);
  add_post_meta(get_the_ID(), 'attend_users', $user->ID);
  add_user_meta($user->ID, 'attend_events', get_the_ID());
  add_user_meta($user->ID, 'attend_events_solo', get_the_ID());
  header('Location: ' . get_the_permalink($work_id)); exit;
}

$group = get_posts(array (
  'post_type' => 'group',
  'meta_query' => array (
    array ('key' => 'members', 'value' => $user->ID),
    array ('key' => 'event', 'value' => get_the_ID())
  )
))[0];
$group_pending = get_posts(array (
  'post_type' => 'group',
  'meta_query' => array (
    array ('key' => 'members_pending', 'value' => $user->ID),
    array ('key' => 'event', 'value' => get_the_ID())
  )
))[0];

$group = $group ?: $group_pending;

if ($group) {
  $im_leader = $group->post_author == $user->ID;
} elseif ($user->ID) {
  $work = get_posts(array ('post_type' =>'work', 'lang' => '', 'author' => $user->ID, 'meta_key' => 'event', 'meta_value' => get_the_ID()))[0];
}

get_header();

if (isset($_GET['participate'])):
  redirect_login();
  $step = $_GET['participate'] ?: 'step-1';
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
          <?php if ($news_ids = get_post_meta(pll_get_post(get_the_ID(), pll_default_language()), 'news', true)): ?>
          <li class="d-none d-lg-block">
            <a class="text-truncate" href="#section5" title="<?=__('相关新闻', 'young-bird')?>"><?=__('相关新闻', 'young-bird')?></a>
          </li>
          <?php endif; ?>
          <?php if ($document = get_field('document')): ?>
          <li class="d-none d-lg-block">
            <a class="text-truncate" href="<?=$document['url']?>" download title="<?=__('下载文件', 'young-bird')?>"><?=__('下载文件', 'young-bird')?></a>
          </li>
          <?php endif; ?>
          <?php foreach (get_posts(array('post_type' => 'rank', 'posts_per_page' => -1, 'meta_key' => 'event', 'meta_value' => get_the_ID())) as $rank): $length =  get_post_meta($rank->ID, 'length', true); ?>
          <li>
            <a class="text-truncate" href="<?=get_the_permalink($rank->ID)?>" title="<?php printf(__('%s强', 'young-bird'), $length); ?>"><?php printf(__('%s强', 'young-bird'), $length); ?></a>
          </li>
          <?php endforeach; ?>
          <li class="active">
            <?php if (current_user_can('edit_user') && get_field('status') === 'ended'): ?>
            <a class="text-truncate d-none d-lg-block" href="<?=pll_home_url()?>work?event_id=<?=get_the_ID()?>" title="<?=__('入围评审', 'young-bird')?>"><?=__('入围评审', 'young-bird')?></a>
            <?php elseif (current_user_can('edit_user')): ?>
            <a class="text-truncate d-none d-lg-block remind-event-ending" href="#" data-days-before-end="<?=ceil((strtotime(get_field('end_date')) - time()) / 86400)?>" title="<?=__('催稿', 'young-bird')?>"><?=__('催稿', 'young-bird')?></a>
            <?php elseif ($attendable = in_array(get_field('status'), array('started', 'ending')) && !$attended = in_array(get_the_ID(), get_user_meta($user->ID, 'attend_events') ?: array ())): ?>
            <a class="text-truncate" href="<?=get_post_meta(get_the_ID(), 'ext_attend_link', true) ?: (get_the_permalink() . '?participate')?>" title="<?=__('参赛', 'young-bird')?>"><?=__('参赛', 'young-bird')?></a>
            <?php elseif ($group && $attended_as_member = in_array(get_the_ID(), get_user_meta($user->ID, 'attend_events_member') ?: array())): ?>
            <a class="text-truncate d-none d-lg-block" href="<?=get_the_permalink($group->ID)?>" title="<?=__('查看团队', 'young-bird')?>"><?=__('查看团队', 'young-bird')?></a>
            <?php elseif ($group || $work): ?>
            <a class="text-truncate d-none d-lg-block" href="<?=$group ? get_the_permalink($group->ID) : get_the_permalink($work->ID)?>" title="<?=__('编辑作品', 'young-bird')?>"><?=__('编辑作品', 'young-bird')?></a>
            <?php endif; ?>
          </li>
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
              <h1 class="color-black font-weight-bold">
                <?php the_title(); ?>
              </h1>
              <span class="time"><?=get_post_meta(get_the_ID(), 'start_date', true)?> ~ <?=get_post_meta(get_the_ID(), 'end_date', true)?></span>
            </div>
            <div class="col-md-6 action d-flex align-items-center justify-content-end mt-2 mt-md-0">
              <?php if (!get_post_meta(get_the_ID(), 'ext_attend_link', true)): ?>
              <i class="far fa-user mr-2"></i>
              <?php if ($attendees = get_post_meta(get_the_ID(), 'attendees', true)): ?>
              <span class="mr-4"><?=__('参赛人数', 'young-bird')?> / <?=$attendees?></span>
              <?php endif; ?>
              <?php endif; ?>
              <i class="<?=in_array(get_the_ID(), get_user_meta(get_current_user_id(), 'like_events') ?: array()) ? 'fas ' : 'far'?> fa-heart like"></i>
            </div>
          </div>
          <div class="row mx-auto justify-content-between align-items-center mt-3">
            <div>
              <?php if ($terms = get_the_terms(get_the_ID(), 'event_category')): foreach ($terms as $term): ?>
              <i class="tag tag-grey" style="padding:5px 10px; background: <?=get_field('color', $term)?>"><?=$term->name?></i>
              <?php endforeach; endif; ?>
            </div>
            <div class="d-none d-md-flex align-items-center share">
              <?=__('分享至：', 'young-bird')?><!-- JiaThis Button BEGIN -->
              <div class="jiathis_style_32x32">
              	<a class="jiathis_button_tsina"></a>
              	<a class="jiathis_button_weixin"></a>
              	<a class="jiathis_button_qzone"></a>
              	<a class="jiathis_button_fb"></a>
              	<a class="jiathis_button_twitter"></a>
              </div>
              <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=" charset="utf-8"></script>
              <!-- JiaThis Button END -->
            </div>
          </div>
        </section>
        <div class="context">
          <h2 class="row align-items-center mx-auto" id="section1">
            <!-- <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt=""> -->
            <span><?=__('竞赛介绍', 'young-bird')?></span>
          </h2>
          <div class="editor">
            <?php the_content(); ?>
          </div>
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
        </div>
      </div>
    </div>
    <div class="container-fluid bg-bg-light-grey" id="section5">
      <div class="container">
        <div class="owl-carousel related-news owl-theme">
          <?php if ($news_ids): $newses = get_posts(array('post__in' => $news_ids)); foreach ($newses as $news): $news = get_post($news->ID) ?>
          <div class="item">
            <a href="<?=get_permalink($news->ID)?>" class="card mb-3 item-sub-history">
              <?=get_the_post_thumbnail($news->ID, '8-7', array ('class' => 'card-img-top'))?>
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
<?php endif; get_footer(); ?>
