<?php

$id_dl = pll_get_post(get_the_ID(), pll_default_language());
$like_posts = get_user_meta(get_current_user_id(), 'like_posts') ?: array();

if (isset($_POST['like'])) {
  redirect_login();
  $like = json_decode($_POST['like']);
  $likes = get_post_meta($id_dl, 'likes', true);
  if ($like && !in_array($id_dl, $like_posts)) {
    add_user_meta(get_current_user_id(), 'like_posts', $id_dl);
    update_post_meta($id_dl, 'likes', ++$likes);
  }
  elseif (!$like && in_array($id_dl, $like_posts)) {
    delete_user_meta(get_current_user_id(), 'like_posts', $id_dl);
    update_post_meta($id_dl, 'likes', --$likes);
  }

  echo $likes; exit;
}

$views = (get_post_meta($id_dl, 'views', true) ?: 0) + 1;
update_post_meta($id_dl, 'views', $views);
$likes = get_post_meta($id_dl, 'likes', true) ?: 0;

get_header(); the_post(); ?>
    <!-- Body -->
    <div class="container pb-4">
      <div class="row">
        <div class="col-md-18 news-detail">
          <section class="header">
            <!-- poster -->
            <div class="text-center">
              <img src="<?=get_field('news_kv')['sizes']['5-3']?>">
            </div>
            <!-- title -->
            <div class="title mt-3">
              <h1 class="color-black"><?php the_title(); ?></h1>
              <span class="published-at"><?=__('发布时间', 'young-bird')?> <?php the_date(); ?></span>
            </div>
            <div class="row justify-content-between align-items-center mt-2 mt-md-4 infos">
              <div class="d-flex align-items-center">
                <i class="fas fa-eye mr-2"></i>
                <span class="mr-4"><?=$views?></span>
                <span class="like-box">
                  <i class="<?=in_array($id_dl, $like_posts) ? 'fas ' : 'far'?> fa-heart mr-2 like"></i>
                  <span class="mr-4 likes"><?=$likes?></span>
                </span>
              </div>
              <div class="d-none d-md-flex align-items-center share mt-3 mt-md-0" style="line-height:0">
                <div class="share-container"></div>
              </div>
            </div>
          </section>
          <?php include(locate_template('single-action-button.php')); ?>
          <div class="editor my-3 my-md-5">
            <?php the_content(); ?>
          </div>
        </div>
        <div class="col-md-6 news-detail-ad">
          <?php foreach (get_posts(array ('category_name' => 'news-detail-ad')) as $ad): ?>
          <a href="<?=get_the_permalink($ad)?>" class="card mb-3 item-sub-history">
            <div>
              <img src="<?=get_field('ad_thumbnail', $ad->ID)['url']?>" class="card-img-top">
            </div>
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
              <p><?=$ad->post_excerpt?></p>
              <?php if ($ad_event = get_field('event', $ad)): ?>
              <p><?=__('截止日期：', 'young-bird')?><?=get_post_meta($ad_event->ID, 'end_date', true)?></p>
              <?php endif; ?>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <a class="scroll-to-top-btn" href="#" style="display: none"><i class="fas fa-chevron-up"></i><br>TOP</a>
<?php get_footer(); ?>
