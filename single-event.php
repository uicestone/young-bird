<?php
if (isset($_GET['participate'])) {
  redirect_login();
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
    wp_update_user($user);
  }
  header('Location: ' . get_the_permalink() . '?participate=' . $_POST['participate']); exit;
}

if (isset($_POST['create_group'])) {
  $groups = get_posts(array (
    'post_type' => 'group',
    'title' => $_POST['group_name_join'],
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
  add_user_meta($user->ID, 'attend_events', get_the_ID());
  add_user_meta($user->ID, 'attend_events_captain', get_the_ID());
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
  add_user_meta($user->ID, 'attend_events', get_the_ID());
  add_user_meta($user->ID, 'attend_events_member', get_the_ID());
  header('Location: ' . get_the_permalink() . '?participate=step-4'); exit;
}

if (isset($_GET['create-work'])) {
  $event_id = get_the_ID();
  $attendees = get_post_meta(get_the_ID(), 'attendees', true) ?: 0;
  $work_id = wp_insert_post(array (
    'post_type' => 'work',
    'post_status' => 'publish',
    'post_title' => '新作品',
    'post_name' => $event_id . '-s' . $user->ID
  ));
  add_post_meta($work_id, 'event', $event_id);
  update_post_meta(get_the_ID(), 'attendees', ++$attendees);
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
} else {
  $work = get_posts(array ('post_type' =>'work', 'event' => get_the_ID(), 'author' => $user->ID))[0];
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
          <li>
            <a href="#section1">竞赛命题</a>
          </li>
          <li>
            <a href="#section2">奖项设置</a>
          </li>
          <li>
            <a href="#section3">评委介绍</a>
          </li>
          <li>
            <a href="#section4">Q&A</a>
          </li>
          <li>
            <a href="#section5">相关新闻</a>
          </li>
          <?php if ($document = get_field('document')): ?>
          <li>
            <a href="<?=$document['url']?>" download>下载文件</a>
          </li>
          <?php endif; ?>
          <li class="active">
            <?php if (!in_array(get_the_ID(), get_user_meta($user->ID, 'attend_events'))): ?>
            <a href="<?php the_permalink(); ?>?participate">参赛</a>
            <?php elseif (in_array(get_the_ID(), get_user_meta($user->ID, 'attend_events_member'))): ?>
            <a href="<?=get_the_permalink($group->ID)?>">查看团队</a>
            <?php else: ?>
            <a href="<?=$group ? get_the_permalink($group->ID) : get_the_permalink($work->ID)?>">编辑作品</a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
      <div class="content">
        <section class="header">
          <!-- poster -->
          <div class="poster">
            <?php the_post_thumbnail('hd'); ?>
          </div>
          <!-- title -->
          <div class="title row justify-content-between align-items-center mx-auto">
            <h1 class="color-black font-weight-bold"><?php the_title(); ?></h1>
            <div class="action">
              <i class="far fa-user mr-2"></i>
              <span class="mr-4">参赛人数 / <?=get_post_meta(get_the_ID(), 'attendees', true)?></span>
              <i class="far fa-heart"></i>
            </div>
          </div>
          <span><?=get_post_meta(get_the_ID(), 'start_date', true)?> ~ <?=get_post_meta(get_the_ID(), 'end_date', true)?></span>
          <div class="row mx-auto justify-content-between align-items-center mt-3">
            <?php foreach (get_the_tags() as $tag): ?>
            <i class="tag tag-rose"><?=$tag->name?></i>
            <?php endforeach; ?>
            <!--<div>
              分享至：
            </div>-->
          </div>
        </section>
        <div class="context">
          <h2 class="row align-items-center mx-auto" id="section1">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt="">
            <span>竞赛命题</span>
          </h2>
          <div class="editor">
            <h3>/设计要求</h3>
            <?php the_content(); ?>
          </div>
          <h2 class="row align-items-center mx-auto" id="section2">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt="">
            <span>奖项设置</span>
          </h2>
          <div class="editor">
            <?=get_field('awards')?>
          </div>
          <h2 class="row align-items-center mx-auto" id="section3">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt="">
            <span>评委介绍</span>
          </h2>
          <div class="editor judge-list row">
            <?php if ($judges = get_field('judges')): foreach ($judges as $judge): ?>
            <div class="col-md-8">
              <a href="<?=get_the_permalink($judge->ID)?>">
                <div class="d-flex align-items-center py-4">
                  <div class="avatar">
                    <?=get_the_post_thumbnail($judge->ID, 'thumbnail')?>
                  </div>
                  <div class="desc pl-3">
                    <p class="color-black font-weight-bold"><?=get_the_title($judge->ID)?></p>
                    <small class="color-black font-weight-bold"><?=get_the_excerpt($judge->ID)?></small>
                  </div>
                </div>
              </a>
            </div>
            <?php endforeach; endif; ?>
          </div>
          <h2 class="row align-items-center mx-auto" id="section4">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt="">
            <span>Q&A</span>
          </h2>
          <div class="editor">
            <?=get_field('q&a')?>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid bg-light-grey" id="section5">
      <div class="container">
        <div class="owl-carousel related-news owl-theme">
          <?php if ($newses = get_field('news')): foreach ($newses as $news): ?>
          <div class="item">
            <a href="<?=get_permalink($news->ID)?>" class="card mb-3 item-sub-history">
              <?=get_the_post_thumbnail($news->ID, '8-7', array ('class' => 'card-img-top'))?>
              <div class="card-label">
                <?php if ($tags = get_the_tags($news->ID)): foreach ($tags as $tag): ?>
                <span>#<?=$tag->name?></span>
                <?php endforeach; endif; ?>
                <div class="tag tag-blue">-标签位置-</div>
              </div>
              <hr />
              <div class="card-body">
                <h4 class="text-truncate"><?=get_the_title($news->ID)?></h4>
                <h4 class="text-truncate"><?=get_the_subtitle($news->ID)?></h4>
              </div>
            </a>
          </div>
          <?php endforeach; endif; ?>
        </div>
      </div>
    </div>
<?php endif; get_footer(); ?>
