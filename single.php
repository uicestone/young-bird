<?php

if (isset($_POST['attend'])) {

  redirect_login();

  $attend = json_decode($_POST['attend']);

  if ($attend) {
    add_user_meta(get_current_user_id(), 'attend_activities', get_the_ID());
  } else {
    delete_user_meta(get_current_user_id(), 'attend_activities', get_the_ID());
  }

  exit;
}

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
            <div class="text-center">
            <!-- <?php the_post_thumbnail('5-3', array('class'=>'mb-4')) ?> -->
            <img src="<?=get_field('news_kv')['sizes']['hd']?>">
            </div>
            <!-- title -->
            <h1 class="color-black"><?php the_title(); ?></h1>
            <span class="published-at"><?=__('发布时间', 'young-bird')?> <?php the_date(); ?></span>
            <div class="row justify-content-between align-items-center mt-2 mt-md-4 infos">
              <div class="d-flex align-items-center">
                <i class="fas fa-eye mr-2"></i>
                <span class="mr-4"><?=$views?></span>
                <i class="far fa-heart mr-2"></i>
                <span class="mr-4"><?=$likes?></span>
              </div>
              <div class="d-none d-md-flex align-items-center share mt-3 mt-md-0">
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
          <div class="editor my-3 my-md-5">
            <?php the_content(); ?>
          </div>
          <?php if ($event = get_field('event') && in_array(get_field('status', $event->ID), array('started', 'ending'))): ?>
          <a href="<?=get_the_permalink($event->ID)?>" class="btn btn-outline-primary mx-auto d-block btn-common mb-4"><?=__('立即报名', 'young-bird')?></a>
          <?php endif; ?>
          <?php if (get_field('attendable')): if (in_array(get_the_ID(), get_user_meta(get_current_user_id(), 'attend_activities'))): ?>
          <button type="button" disabled class="btn btn-outline-primary mx-auto d-block btn-common mb-4 attend-activity"><?=__('已报名', 'young-bird')?></button>
          <?php else: ?>
          <button type="button" class="btn btn-outline-primary mx-auto d-block btn-common mb-4 attend-activity"><?=__('立即报名', 'young-bird')?></button>
          <?php endif; endif; ?>
        </div>
        <div class="col-md-6">
          <?php foreach (get_posts(array ('category_name' => 'news-detail-ad')) as $ad): ?>
          <a href="<?=get_the_permalink($ad)?>" class="card mb-3 item-sub-history">
            <img src="<?=get_field('ad_thumbnail', $ad->ID)['url']?>" class="card-img-top">
            <div class="card-label">
              <span class="hashtag"># <?=strip_tags(get_the_tag_list('', '、', '', $ad->ID))?></span>
              <div>
                <?php foreach (get_the_terms($ad->ID, 'news_category') ?: array() as $term): ?>
                <i class="tag tag-grey" style="background: <?=get_field('color', $term)?>"><?=$term->name?></i>
                <?php endforeach; ?>
              </div>
            </div>
            <hr />
            <div class="card-body">
              <h4><?=get_the_title($ad->ID)?><br><?=get_the_subtitle($ad->ID)?></h4>
              <p><?=get_the_excerpt($ad)?></p>
              <?php if ($ad_event = get_field('event', $ad)): ?>
              <p><?=__('截止日期：', 'young-bird')?><?=get_post_meta($ad_event->ID, 'end_date', true)?></p>
              <?php endif; ?>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
<?php get_footer(); ?>
