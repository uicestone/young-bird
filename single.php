<?php
$views = (get_post_meta(get_the_ID(), 'views', true) ?: 0) + 1;
update_post_meta(get_the_ID(), 'views', $views);
$likes = get_post_meta(get_the_ID(), 'likes', true) ?: 0;

get_header(); the_post(); ?>
    <!-- Body -->
    <div class="container pb-4">
      <div class="row">
        <div class="col-md-18 news-detail">
          <section class="header">
            <!-- poster -->
            <div class="row justify-content-center">
            <?php the_post_thumbnail('5-3', array('class'=>'mb-4')) ?>
            </div>
            <!-- title -->
            <h1 class="color-black"><?php the_title(); ?></h1>
            <span>发布时间 <?php the_date(); ?></span>
            <div class="row justify-content-between align-items-center mt-4">
              <div class="d-flex align-items-center">
                <i class="fas fa-eye mr-2"></i>
                <span class="mr-4"><?=$views?></span>
                <i class="far fa-heart mr-2"></i>
                <span class="mr-4"><?=$likes?></span>
              </div>
              <div>
                分享至：
              </div>
            </div>
          </section>
          <div class="editor my-5">
            <?php the_content(); ?>
          </div>
          <?php if ($event = get_field('event')): ?>
          <a href="<?=get_the_permalink($event->ID)?>" class="btn btn-outline-primary mx-auto d-block btn-common mb-4">立即报名</a>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <?php foreach (get_posts(array ('category_name' => 'ad')) as $ad): ?>
          <a href="<?=get_the_permalink($ad->ID)?>" class="card mb-3 item-sub-history">
            <?=get_the_post_thumbnail($ad->ID, '8-7', array ('class' => 'card-img-top'))?>
            <div class="card-label">
              <?php foreach (get_the_tags($ad->ID) as $tag): ?>
              <span>#<?=$tag->name?></span>
              <?php endforeach; ?>
              <div class="tag tag-blue">-标签位置-</div>
            </div>
            <hr />
            <div class="card-body">
              <h4><?=get_the_title($ad->ID)?><br><?=get_the_subtitle($ad->ID)?></h4>
              <?php if ($ad_event = get_field('event', $ad)): ?>
              <p>截止日期：<?=get_post_meta($ad_event->ID, 'end_date', true)?></p>
              <?php endif; ?>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
<?php get_footer(); ?>
