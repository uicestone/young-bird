    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-help-center.jpg) center center / cover no-repeat">
      <div class="container">
        <?php if (current_user_can('judge_works')): ?>
        <h1>_大咖中心 <br>JUDGE CENTER</h1>
        <?php else: ?>
        <h1>_用户中心 <br>USER CENTER</h1>
        <?php endif; ?>
      </div>
    </div>
    <!-- Menu -->
    <div class="container-fluid user-center-menu">
      <div class="container">
        <ul>
          <li><a href="<?=pll_home_url()?>user-center/"><?=__('个人信息', 'young-bird')?></a></li>
          <li class="active"><a href="<?=pll_home_url()?>user-center/?event"><?=__('我的竞赛', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>user-center/?activity"><?=__('我的活动', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>user-center/?like"><?=__('我的收藏', 'young-bird')?></a></li>
          <li>
            <a href="<?=pll_home_url()?>message/"><?=__('消息', 'young-bird')?>
              <?php if ($has_unread_message = get_user_meta(get_current_user_id(), 'has_unread_message', true)): ?><i></i><?php endif; ?>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body">
      <?php if (current_user_can('judge_works')): ?>
      <h3><?=__('（待）评分的项目', 'young-bird')?></h3>
      <div class="row my-3 event-list">
        <?php if ($judge_post): foreach (get_posts(array (
          'post_type' => 'event', 'meta_key' => 'judges',
          'meta_compare' => 'LIKE', 'meta_value' => '"' . $judge_post->ID . '"'
        )) as $event):
          if (!in_array($judge_post->ID, array_column(get_field('judges', $event->ID), 'ID'))) {
            continue;
          }
        ?>
          <div class="col-md-12">
            <div class="card mb-4 item-event">
              <div class="card-head row mx-0">
                <div class="tag tag-red col-3 text-center"><?=get_event_status($event->ID)?></div>
                <div class="bg-black color-white col-21 d-flex align-items-center justify-content-end">
                  <?php foreach (get_the_terms($event->ID, 'event_category') as $term): ?>
                    <span><?=$term->name?></span>
                  <?php endforeach; ?>
                </div>
              </div>
              <a href="<?=get_the_permalink($event->ID)?>" class="link">
                <?=get_the_post_thumbnail($event->ID, 'vga', array('class' => 'card-img-top'))?>
              </a>
              <div class="card-body mt-3">
                <div class="row justify-content-between mx-auto pt-3 mb-3">
                  <h3 style="height:3rem"><?=get_the_title($event->ID)?><br><?=get_the_subtitle($event->ID)?></h3>
                  <strong><?=__('竞赛时间', 'young-bird')?>/<?=get_post_meta($event->ID, 'start_date', true)?> ~ <?=get_post_meta($event->ID, 'end_date', true)?></strong>
                </div>
                <div class="action row align-items-center justify-content-between">
                  <div class="d-flex align-items-center" style="height:1.2rem">
                    <?php if ($attendees = get_post_meta($event->ID, 'attendees', true) ?: 0): ?>
                    <i class="far fa-user mr-2"></i>
                    <span class="mr-4"><?=__('参赛人数', 'young-bird')?> / <?=$attendees?></span>
                    <?php endif; ?>
                  </div>
                  <div>
                    <?php if (get_post_meta($event->ID, 'status', true) === 'ended'): ?>
                    <button type="button" onclick="location.href='<?=site_url('/work/?event_id=' . $event->ID)?>';return false" class="btn btn-outline-primary ml-2"><?=__('评审作品', 'young-bird')?></button>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; endif; ?>
        </div>
      <?php else: ?>
      <h3><?=__('参与的项目', 'young-bird')?></h3>
      <div class="row my-3 event-list">
        <?php if ($attend_events = get_user_meta($user->ID, 'attend_events')): foreach (get_posts(array ('post_type' => 'event', 'post__in' => $attend_events ?: array())) as $event): ?>
        <div class="col-md-12">
          <div class="card mb-4 item-event">
            <div class="card-head row mx-0">
              <div class="tag tag-red col-3 text-center"><?=get_event_status($event->ID)?></div>
              <div class="bg-black color-white col-21 d-flex align-items-center justify-content-end">
                <?php foreach (get_the_terms($event->ID, 'event_category') as $term): ?>
                <span><?=$term->name?></span>
                <?php endforeach; ?>
              </div>
            </div>
            <a href="<?=get_the_permalink($event->ID)?>" class="link">
              <?=get_the_post_thumbnail($event->ID, 'vga', array('class' => 'card-img-top'))?>
            </a>
            <div class="card-body mt-3">
              <div class="row justify-content-between mx-auto pt-3 mb-3">
                <h3><?=get_the_title($event->ID)?><br><?=get_the_subtitle($event->ID)?></h3>
                <strong><?=__('竞赛时间', 'young-bird')?>/<?=get_post_meta($event->ID, 'start_date', true)?> ~ <?=get_post_meta($event->ID, 'end_date', true)?></strong>
              </div>
              <div class="action row align-items-center justify-content-between">
                <div class="d-flex align-items-center" style="height:1.2rem">
                  <?php if ($attendees = get_post_meta($event->ID, 'attendees', true) ?: 0): ?>
                  <i class="far fa-user mr-2"></i>
                  <span class="mr-4"><?=__('参赛人数', 'young-bird')?> / <?=$attendees?></span>
                  <?php endif; ?>
                </div>
                <div>
                  <?php $work = get_event_work($event->ID); ?>
                  <?php if ($work): ?>
                  <button type="button" class="btn btn-outline-primary btn-preview ml-2 item-work-anchor"><?=__('我的作品', 'young-bird')?></button>
                  <div class="d-none">
                    <a class="w-100" style="padding:10vh 20vw">
                      <div class="row mx-auto justify-content-between">
                        <h3><?php get_the_title($work->ID); ?></h3>
                        <h4>YB<?=strtoupper($work->post_name)?></h4>
                      </div>
                      <p class="mt-3">
                        <?=get_post_meta($work->ID, 'description', true)?>
                      </p>
                    </a>
                    <a href="<?=get_the_post_thumbnail_url($work->ID)?>">
                      <?php get_the_post_thumbnail($work->ID, 'full'); ?>
                    </a>
                    <?php foreach (get_post_meta($work->ID, 'images') as $image_url): ?>
                    <a href="<?=$image_url?>">
                      <img src="<?=$image_url?>" alt="" />
                    </a>
                    <?php endforeach; ?>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; endif; ?>
      </div>
      <?php endif; ?>
      <h3><?=__('关注的项目', 'young-bird')?></h3>
      <div class="row my-3 event-list">
        <?php if ($like_events = get_user_meta($user->ID, 'like_events')): foreach (get_posts(array('post_type' => 'event', 'post__in' => $like_events)) as $event): ?>
        <div class="col-md-12">
          <div class="card mb-4 item-event">
            <div class="card-head row mx-0">
              <div class="tag tag-red col-3 text-center"><?=get_event_status($event->ID)?></div>
              <div class="bg-black color-white col-21 d-flex align-items-center justify-content-end">
                <?php foreach (get_the_terms($event->ID, 'event_category') as $term): ?>
                <span><?=$term->name?></span>
                <?php endforeach; ?>
              </div>
            </div>
            <a href="<?=get_the_permalink($event->ID)?>" class="link">
              <?=get_the_post_thumbnail($event->ID, 'vga', array('class' => 'card-img-top'))?>
            </a>
            <div class="card-body mt-3">
              <div class="row justify-content-between mx-auto pt-3 mb-3">
                <h3 style="height:3rem"><?=get_the_title($event->ID)?><br><?=get_the_subtitle($event->ID)?></h3>
                <strong><?=__('竞赛时间', 'young-bird')?>/<?=get_post_meta($event->ID, 'start_date', true)?> ~ <?=get_post_meta($event->ID, 'end_date', true)?></strong>
              </div>
              <div class="action row align-items-center justify-content-between">
                <div class="d-flex align-items-center" style="height:1.2rem">
                  <?php if ($attendees = get_post_meta($event->ID, 'attendees', true) ?: 0): ?>
                  <i class="far fa-user mr-2"></i>
                  <span class="mr-4"><?=__('参赛人数', 'young-bird')?> / <?=$attendees?></span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; endif; ?>
      </div>
      <a href="<?=pll_home_url()?>event/" class="btn btn-outline-primary mx-auto d-block btn-common mb-4"><?=__('发现更多', 'young-bird')?></a>
    </div>
