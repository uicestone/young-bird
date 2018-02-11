<?php

the_post();

if ($accept_member = $_POST['accept_member_request']) {
  add_post_meta(get_the_ID(), 'members', $accept_member);
  delete_post_meta(get_the_ID(), 'members_pending', $accept_member);
  header('Location: ' . get_the_permalink()); exit;
}

if ($ignore_member = $_POST['ignore_member_request']) {
  delete_post_meta(get_the_ID(), 'members_pending', $ignore_member);
  header('Location: ' . get_the_permalink()); exit;
}

if ($remove_member = $_GET['remove_member']) {
  delete_post_meta(get_the_ID(), 'members', $remove_member);
  header('Location: ' . get_the_permalink()); exit;
}

if (isset($_GET['create-work'])) {
  $event_id = get_post_meta(get_the_ID(), 'event', true);
  $work_id = wp_insert_post(array (
    'post_type' => 'work',
    'post_status' => 'publish',
    'post_title' => '新作品',
    'post_name' => $event_id . '-' . get_the_ID()
  ));
  add_post_meta($work_id, 'event', $event_id);
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
          <h3><?php the_title(); ?>（成员/<?=count(get_post_meta(get_the_ID(), 'members'))?>）</h3>
          <h3>参赛编号：YB<?=get_the_ID()?></h3>
        </div>
        <div class="member-list">
          <?php $captain = get_user_by('ID', get_post()->post_author) ?>
          <div class="captain avatar-container d-flex align-items-center">
            <?=get_avatar($member_id, 128, '', '', array('class' => 'rounded-circle'))?>
            <div class="ml-4">
              <div class="role">/组长</div>
              <div class="name"><?=$captain->display_name?></div>
            </div>
          </div>
          <div class="d-flex flex-wrap">
            <?php foreach (get_post_meta(get_the_ID(), 'members') as $member_id): if ($member_id == get_post()->post_author) continue; ?>
            <div class="avatar-container d-flex align-items-center">
              <?=get_avatar($member_id, 128, '', '', array('class' => 'rounded-circle'))?>
              <div class="ml-4">
                <div class="role">/组员</div>
                <div class="name"><?=get_user_by('ID', $member_id)->display_name?></div>
              </div>
              <?php if ($captain->ID == get_current_user_id()): ?>
              <a href="<?php the_permalink(); ?>?remove_member=<?=$member_id?>">
                <i class="fas fa-times"></i>
              </a>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <?php if ($captain->ID == get_current_user_id()): foreach (get_post_meta(get_the_ID(), 'members_pending') as $member_id): ?>
            <div class="avatar-container d-flex flex-column align-items-center">
              <div class="d-flex align-items-center">
                <?=get_avatar($member_id, 80, '', '', array('class' => 'rounded-circle'))?>
                <strong class="name ml-4"><?=get_user_by('ID', $member_id)->display_name?></strong>
              </div>
                <div class="row">
                  <div class="col-12">
                    <form method="post">
                      <button type="submit" name="accept_member_request" value="<?=$member_id?>" class="btn btn-outline-secondary btn-block">同意</button>
                    </form>
                  </div>
                  <div class="col-12">
                    <form method="post">
                      <button type="submit" name="ignore_member_request" value="<?=$member_id?>" class="btn btn-outline-secondary btn-block">忽略</button>
                    </form>
                  </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
          </div>
        </div>
      </div>
      <div class="container works">
        <div class="row header">
          <h3>作品</h3>
        </div>
        <div class="work-list">
          <?php if (!$work = get_posts(array ('post_type' => 'work', 'meta_key' => 'group', 'meta_value' => get_the_ID()))[0]): ?>
          <!-- 未上传 -->
          <div class="no-work">
            <div class="row">
              <div class="col">
                <h3 class="color-black mt-4 mb-3">请上传您的作品</h3>
              </div>
            </div>
            <div class="row justify-content-end">
              <div class="col d-flex justify-content-end">
                <a href="<?php the_permalink(); ?>?create-work" class="btn btn-outline-secondary btn-common">上传</a>
              </div>
            </div>
          </div>
          <?php else: ?>
          <!-- 已上传 -->
          <div class="row mt-6 work-container">
            <div class="col-sm-12 mb-4 mb-md-0">
              <img src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-work.jpg" width="100%" alt="">
            </div>
            <div class="col-sm-12 order-sm-first card item-top3">
              <div class="card-body pb-5">
                <h3><?=get_the_title($work->ID)?></h3>
                <p><?=get_the_excerpt($work->ID)?></p>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col d-flex justify-content-end">
              <a href="<?=get_the_permalink($work->ID)?>" class="btn btn-outline-secondary btn-common">修改</a>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
<?php get_footer(); ?>
