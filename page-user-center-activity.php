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
          <li><a href="<?php the_permalink(); ?>?event"><?=__('我的竞赛', 'young-bird')?></a></li>
          <li class="active"><a href="<?php the_permalink(); ?>?activity"><?=__('我的活动', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>message/"><?=__('消息', 'young-bird')?><i></i></a></li>
        </ul>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body">
      <h3><?=__('报名的活动', 'young-bird')?></h3>
      <div class="row my-3 event-list">
        <?php if ($attend_activities = get_user_meta($user->ID, 'attend_activities')): foreach (get_posts(array ('post_type' => 'post', 'post__in' => $attend_activities ?: array())) as $activity): ?>
        <div class="col-md-12">
          <a href="<?=get_the_permalink($activity->ID)?>" class="card mb-4 item-event link">
            <div class="card-head row mx-0">
              <div class="tag tag-red col-3 text-center">
                <?php foreach (get_the_terms($activity->ID, 'news_category') as $term): ?>
                <span><?=$term->name?></span>
                <?php endforeach; ?>
              </div>
              <div class="bg-black color-white col-21 d-flex align-items-center justify-content-end">
                <?php foreach (get_the_tags($activity->ID) as $tag): ?>
                <span><?=$tag->name?></span>
                <?php endforeach; ?>
              </div>
            </div>
            <?=get_the_post_thumbnail($activity->ID, 'vga', array('class' => 'card-img-top'))?>
            <div class="card-body mt-3">
              <div class="row justify-content-between mx-auto pt-3 mb-3">
                <h3><?=get_the_title($activity->ID)?><br><?=get_the_subtitle($activity->ID)?></h3>
              </div>
            </div>
          </a>
        </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
