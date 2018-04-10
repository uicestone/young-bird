    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-history.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_历 史 <br>HISTORY</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-4">
      <div class="row">
        <div class="col-md-18">
          <div class="row">
            <?php while (have_posts()): the_post(); $id_dl = pll_get_post(get_the_ID(), pll_default_language()); ?>
            <div class="col-md-12">
              <div class="card mb-4 item-history">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('vga', array ('class' => 'card-img-top')); ?>
                  <div class="card-body mt-4">
                    <div class="row head justify-content-between align-items-center">
                      <div class="labels">
                        <?php if ($event_category = get_the_terms(get_the_ID(), 'event_category')): foreach ($event_category as $term): ?>
                        <b class="label color-grey" style="color: <?=get_field('color', $term)?>"><?=$term->name?></b>
                        <?php endforeach; endif; ?>
                      </div>
                      <div><?=get_post_meta(get_the_ID(), 'start_date', true)?> ~ <?=get_post_meta(get_the_ID(), 'end_date', true)?></div>
                    </div>
                    <h3 class="mt-3"><?php the_title(); ?></h3>
                    <p class="color-black mb-4 organizer"><?=get_post_meta(get_the_ID(), 'organizer', true)?></p>
                    <p class="color-silver"><?=$post->post_excerpt?></p>
                    <div class="action row align-items-center">
                      <i class="far fa-user mr-2"></i>
                      <span class="mr-4"><?=__('参赛人数', 'young-bird')?> / <?=get_post_meta($id_dl, 'attendees', true) ?: 0?></span>
                      <i class="<?=in_array(get_the_ID(), get_user_meta(get_current_user_id(), 'like_events') ?: array()) ? 'fas ' : 'far'?> fa-heart like" data-post-link="<?=get_the_permalink(get_the_ID())?>"></i>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <?php endwhile; ?>
          </div>
          <!--<button type="button" class="btn btn-outline-primary mx-auto d-block btn-common mb-4"><?=__('发现更多', 'young-bird')?></button>-->
        </div>
        <div class="col-md-6">
          <?php foreach (get_posts(array ('category_name' => 'event-history-list-ad')) as $ad): ?>
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
