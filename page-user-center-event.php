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
          <li><a href="<?=site_url()?>/user-center/">个人信息</a></li>
          <li class="active"><a href="<?=site_url()?>/event/?user-center">我的竞赛</a></li>
          <li><a href="<?=site_url()?>/message/">消息<i></i></a></li>
        </ul>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body">
      <?php if (current_user_can('judge_works')): ?>
        <h3>（待）评分的项目</h3>
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
              <a href="<?=get_the_permalink($event->ID)?>" class="card mb-4 item-event link">
                <div class="card-head row mx-0">
                  <div class="tag tag-red col-3 text-center"><?=get_event_status($event->ID)?></div>
                  <div class="bg-black color-white col-21 d-flex align-items-center justify-content-end">
                    <?php foreach (get_the_terms($event->ID, 'event_category') as $term): ?>
                      <span><?=$term->name?></span>
                    <?php endforeach; ?>
                  </div>
                </div>
                <?=get_the_post_thumbnail($event->ID, 'vga', array('class' => 'card-img-top'))?>
                <div class="card-body mt-3">
                  <div class="row justify-content-between mx-auto pt-3 mb-3">
                    <h3><?=get_the_title($event->ID)?><br><?=get_the_subtitle($event->ID)?></h3>
                    <strong>竞赛时间/<?=get_post_meta($event->ID, 'start_date', true)?> ~ <?=get_post_meta($event->ID, 'end_date', true)?></strong>
                  </div>
                  <div class="action row align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <i class="far fa-user mr-2"></i>
                      <span class="mr-4">参赛人数 / <?=get_post_meta($event->ID, 'attendees', true) ?: 0?></span>
                    </div>
                    <div>
                      <button type="button" class="btn btn-outline-primary ml-2">我的作品</button>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; endif; ?>
        </div>
      <?php else: ?>
      <h3>参与的项目</h3>
      <div class="row my-3 event-list">
        <?php if ($attend_events = get_user_meta($user->ID, 'attend_events')): foreach (get_posts(array ('post_type' => 'event', 'post__in' => $attend_events ?: array())) as $event): ?>
        <div class="col-md-12">
          <a href="<?=get_the_permalink($event->ID)?>" class="card mb-4 item-event link">
            <div class="card-head row mx-0">
              <div class="tag tag-red col-3 text-center"><?=get_event_status($event->ID)?></div>
              <div class="bg-black color-white col-21 d-flex align-items-center justify-content-end">
                <?php foreach (get_the_terms($event->ID, 'event_category') as $term): ?>
                <span><?=$term->name?></span>
                <?php endforeach; ?>
              </div>
            </div>
            <?=get_the_post_thumbnail($event->ID, 'vga', array('class' => 'card-img-top'))?>
            <div class="card-body mt-3">
              <div class="row justify-content-between mx-auto pt-3 mb-3">
                <h3><?=get_the_title($event->ID)?><br><?=get_the_subtitle($event->ID)?></h3>
                <strong>竞赛时间/<?=get_post_meta($event->ID, 'start_date', true)?> ~ <?=get_post_meta($event->ID, 'end_date', true)?></strong>
              </div>
              <div class="action row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                  <i class="far fa-user mr-2"></i>
                  <span class="mr-4">参赛人数 / <?=get_post_meta($event->ID, 'attendees', true) ?: 0?></span>
                </div>
                <div>
                  <button type="button" class="btn btn-outline-primary ml-2">我的作品</button>
                </div>
              </div>
            </div>
          </a>
        </div>
        <?php endforeach; endif; ?>
      </div>
      <?php endif; ?>
      <h3>关注的项目</h3>
      <div class="row my-3 event-list">
        <?php if ($like_events = get_user_meta($user->ID, 'like_events')): foreach (get_posts(array('post_type' => 'event', 'post__in' => $like_events)) as $event): ?>
        <div class="col-md-12">
          <a href="<?=get_the_permalink($event->ID)?>" class="card mb-4 item-event link">
            <div class="card-head row mx-0">
              <div class="tag tag-red col-3 text-center"><?=get_event_status($event->ID)?></div>
              <div class="bg-black color-white col-21 d-flex align-items-center justify-content-end">
                <?php foreach (get_the_terms($event->ID, 'event_category') as $term): ?>
                <span><?=$term->name?></span>
                <?php endforeach; ?>
              </div>
            </div>
            <?=get_the_post_thumbnail($event->ID, 'vga', array('class' => 'card-img-top'))?>
            <div class="card-body mt-3">
              <div class="row justify-content-between mx-auto pt-3 mb-3">
                <h3><?=get_the_title($event->ID)?><br><?=get_the_subtitle($event->ID)?></h3>
                <strong>竞赛时间/<?=get_post_meta($event->ID, 'start_date', true)?> ~ <?=get_post_meta($event->ID, 'end_date', true)?></strong>
              </div>
              <div class="action row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                  <i class="far fa-user mr-2"></i>
                  <span class="mr-4">参赛人数 / <?=get_post_meta($event->ID, 'attendees', true) ?: 0?></span>
                </div>
              </div>
            </div>
          </a>
        </div>
        <?php endforeach; endif; ?>
      </div>
      <a href="<?=site_url('/event/')?>" class="btn btn-outline-primary mx-auto d-block btn-common mb-4">发现更多</a>
    </div>
