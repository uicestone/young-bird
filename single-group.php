<?php

the_post();
$event_id = get_post_meta(get_the_ID(), 'event', true);
$captain = get_user_by('ID', get_post()->post_author);
$work = get_posts(array ('post_type' => 'work', 'meta_key' => 'group', 'meta_value' => get_the_ID()))[0];
$members = get_post_meta(get_the_ID(), 'members') ?: array();
$members_pending = get_post_meta(get_the_ID(), 'members_pending') ?: array();

if ($accept_member = $_POST['accept_member_request']) {
  add_post_meta(get_the_ID(), 'members', $accept_member);
  delete_post_meta(get_the_ID(), 'members_pending', $accept_member);
  $attendees = get_post_meta($event_id, 'attendees', true) ?: 0;
  update_post_meta($event_id, 'attendees', ++$attendees);
  send_message($accept_member, 'you-are-a-team-member-now', array('team' => get_the_ID()));
  header('Location: ' . get_the_permalink()); exit;
}

if ($ignore_member = $_POST['ignore_member_request']) {
  delete_post_meta(get_the_ID(), 'members_pending', $ignore_member);
  send_message($ignore_member, 'team-join-declined');
  header('Location: ' . get_the_permalink()); exit;
}

if ($remove_member = $_GET['remove_member']) {
  delete_post_meta(get_the_ID(), 'members', $remove_member);
  $attendees = get_post_meta($event_id, 'attendees', true) ?: 0;
  update_post_meta($event_id, 'attendees', --$attendees);
  header('Location: ' . get_the_permalink()); exit;
  // TODO handle message send
  // TODO handle user attend_events_member and attend_events
}

if (isset($_GET['create-work'])) {
  $work_id = wp_insert_post(array (
    'post_type' => 'work',
    'post_status' => 'publish',
    'post_title' => __('新作品', 'young-bird'),
    'post_name' => $event_id . '-g' . get_the_ID()
  ));
  add_post_meta($work_id, 'event', pll_get_post($event_id, pll_default_language()));
  add_post_meta($work_id, 'group', get_the_ID());
  header('Location: ' . get_the_permalink($work_id)); exit;
}

get_header(); ?>
    <!-- Banner -->
    <!-- for desktop -->
    <div class="container-fluid px-0 d-none d-lg-block">
      <img src="<?=get_field('banner_desktop')['url']?>" width="100%" alt="">
    </div>
    <!-- for pad -->
    <div class="container-fluid px-0 d-none d-md-block d-lg-none">
      <img src="<?=get_field('banner_pad')['url']?>" width="100%" alt="">
    </div>
    <!-- for smart phone -->
    <div class="container-fluid px-0 d-md-none">
      <img src="<?=get_field('banner_phone')['url']?>" width="100%" alt="">
    </div>
    <!-- Body -->
    <div class="mt-7 pb-7 page-group-detail">
      <div class="container members mb-5">
        <div class="row justify-content-between header mb-3">
          <h3 class="color-silver font-weight-bold"><?php the_title(); ?>（<?=__('成员', 'young-bird')?>/<?=count($members)?>）</h3>
          <h3 class="color-silver font-weight-bold"><?=__('参赛编号：', 'young-bird')?>YB<?=$event_id?>-<?=get_the_ID()?></h3>
        </div>
        <div class="member-list">
          <div class="captain avatar-container d-flex align-items-center">
            <?php if ($avatar_url = get_user_meta($captain->ID, 'avatar', true)): ?>
            <img src="<?=$avatar_url?>" width="128" height="128" class="rounded-circle">
            <?php else: ?>
            <?=get_avatar($captain->ID, 128, '', '', array('class' => 'rounded-circle'))?>
            <?php endif; ?>
            <div class="ml-4">
              <div class="role color-silver">/<?=__('组长', 'young-bird')?></div>
              <div class="name color-silver text-truncate"><?=$captain->display_name?></div>
            </div>
          </div>
          <div class="d-flex flex-wrap">
            <?php foreach ($members as $member_id): if ($member_id == get_post()->post_author) continue; ?>
            <div class="avatar-container d-flex align-items-center">
              <?php if ($avatar_url = get_user_meta($member_id, 'avatar', true)): ?>
              <img src="<?=$avatar_url?>" width="128" height="128" class="rounded-circle">
              <?php else: ?>
              <?=get_avatar($member_id, 128, '', '', array('class' => 'rounded-circle'))?>
              <?php endif; ?>
              <div class="ml-4">
                <div class="role color-silver">/<?=__('组员', 'young-bird')?></div>
                <div class="name color-silver text-truncate"><?=get_user_by('ID', $member_id)->display_name?></div>
              </div>
              <?php if ($captain->ID == get_current_user_id()): ?>
              <a href="<?php the_permalink(); ?>?remove_member=<?=$member_id?>">
                <i class="fas fa-times"></i>
              </a>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <?php if ($captain->ID == get_current_user_id()): foreach ($members_pending as $member_id): ?>
            <div class="avatar-container d-flex flex-column align-items-center">
              <div class="d-flex align-items-center">
                <?php if ($avatar_url = get_user_meta($member_id, 'avatar', true)): ?>
                <img src="<?=$avatar_url?>" width="80" height="80" class="rounded-circle">
                <?php else: ?>
                <?=get_avatar($member_id, 80, '', '', array('class' => 'rounded-circle'))?>
                <?php endif; ?>
                <strong class="name text-truncate ml-4"><?=get_user_by('ID', $member_id)->display_name?></strong>
              </div>
                <div class="row">
                  <div class="col-12">
                    <form method="post">
                      <button type="submit" name="accept_member_request" value="<?=$member_id?>" class="btn btn-outline-primary btn-block"><?=__('同意', 'young-bird')?></button>
                    </form>
                  </div>
                  <div class="col-12">
                    <form method="post">
                      <button type="submit" name="ignore_member_request" value="<?=$member_id?>" class="btn btn-outline-primary btn-block"><?=__('拒绝', 'young-bird')?></button>
                    </form>
                  </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
            <?php if (in_array(get_current_user_id(), $members_pending)): ?>
            <div class="avatar-container d-flex flex-column align-items-center">
              <div class="d-flex align-items-center">
                <?=get_avatar(get_current_user_id(), 80, '', '', array('class' => 'rounded-circle'))?>
                <strong class="name text-truncate ml-4"><?=wp_get_current_user()->display_name?></strong>
              </div>
              <div class="row">
                <div class="offset-12 col-12">
                  <button type="button" disabled class="btn btn-outline-primary btn-block"><?=__('待队长审批', 'young-bird')?></button>
                </div>
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="container works">
        <div class="row header">
          <h3 class="color-silver font-weight-bold"><?=__('作品', 'young-bird')?></h3>
        </div>
        <div class="work-list">
          <?php if (get_current_user_id() == $captain->ID && !$work): ?>
          <!-- 未上传 -->
          <div class="no-work">
            <div class="row">
              <div class="col">
                <h3 class="font-weight-bold color-black mt-4 mb-3"><?=__('请上传您的作品', 'young-bird')?></h3>
              </div>
            </div>
            <div class="row justify-content-end">
              <div class="col d-flex justify-content-end">
                <a href="<?php the_permalink(); ?>?create-work" class="btn btn-outline-primary btn-common"><?=__('上传', 'young-bird')?></a>
              </div>
            </div>
          </div>
          <?php elseif ($work): ?>
          <!-- 已上传 -->
          <div class="row mt-6 work-container">
            <div class="col-sm-12 mb-4 mb-md-0">
              <?=get_the_post_thumbnail($work->ID, 'vga')?>
            </div>
            <div class="col-sm-12 order-sm-first card item-top3">
              <div class="card-body pb-5">
                <h3><?=get_the_title($work->ID)?></h3>
                <?=wpautop(get_post_meta($work->ID, 'description', true))?>
              </div>
            </div>
          </div>
          <?php   if (in_array(get_current_user_id(), $members)): ?>
          <div class="row mt-4">
            <div class="col d-flex justify-content-end">
              <a href="<?=get_the_permalink($work->ID)?>" class="btn btn-outline-primary btn-common"><?=__(($captain->ID == get_current_user_id() ? '修改' : '查看'), 'young-bird')?></a>
            </div>
          </div>
          <?php   endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
<?php get_footer(); ?>
