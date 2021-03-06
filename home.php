<?php get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid px-0 banner-home owl-carousel owl-theme">
      <?php foreach (get_posts(array('category_name' => 'home-banner', 'post_type' => 'any', 'posts_per_page' => -1)) as $banner): ?>
      <a<?=get_field('has_content', $banner) ? ' href="' . get_the_permalink($banner->ID) . '"' : ''?>>
        <!-- for desktop -->
        <div class="container-fluid px-0 d-none d-lg-block">
          <img src="<?=get_field('home_banner_desktop', $banner)['url']?>">
        </div>
        <!-- for pad -->
        <div class="container-fluid px-0 d-none d-md-block d-lg-none">
          <img src="<?=get_field('home_banner_pad', $banner)['url']?>">
        </div>
        <!-- for smart phone -->
        <div class="container-fluid px-0 d-md-none">
          <img src="<?=get_field('home_banner_phone', $banner)['url']?>">
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- 热门竞赛 -->
    <div class="container mt-5 mt-lg-7">
      <div class="htitle text-center">
        <span></span>
        <h1><?=__('热门竞赛', 'young-bird')?></h1>
      </div>
      <div class="category home-event-status mb-4">
        <div class="row justify-content-center">
          <div class="d-flex align-items-center mx-5 mx-md-4 mb-2">
            <i class="icon starting mr-3"></i>
            <span><?=__('即将开始', 'young-bird')?></span>
          </div>
          <div class="d-flex align-items-center mx-5 mx-md-4 mb-2">
            <i class="icon started mr-3"></i>
            <span><?=__('开始报名', 'young-bird')?></span>
          </div>
          <div class="d-flex align-items-center mx-5 mx-md-4 mb-2">
            <i class="icon ending mr-3"></i>
            <span><?=__('即将截止', 'young-bird')?></span>
          </div>
          <div class="d-flex align-items-center mx-5 mx-md-4 mb-2">
            <i class="icon ended mr-3"></i>
            <span><?=__('报名截止', 'young-bird')?></span>
          </div>
        </div>
      </div>
      <a href="<?=pll_home_url()?>event/" class="btn btn-outline-primary mx-auto d-block btn-common"><?=__('发现更多', 'young-bird')?></a>
      <div class="row justify-content-between list-competiton mt-4">
        <?php foreach (get_posts(array ('post_type' => 'event', 'category_name' => 'home-primary', 'posts_per_page' => 4)) as $event): ?>
        <div class="col-md-12 col-lg-6">
          <a href="<?=get_the_permalink($event->ID)?>" class="card link">
            <div>
            <?=get_the_post_thumbnail($event->ID, 'vga', array ('class' => 'card-img-top'))?>
            </div>
            <div class="card-body">
              <h5 class="text-truncate" title="<?=get_the_title($event->ID)?>"><?=get_the_title($event->ID)?></h5>
              <h5 class="text-truncate"><?=get_the_subtitle($event->ID)?></h5>
              <span class="end-date"><?=__('截止日期', 'young-bird')?>/<?=get_post_meta($event->ID, 'end_date', true)?></span>
              <?php $status = get_post_meta($event->ID, 'status', true); ?>
              <?php if (in_array($status, array('starting', 'started', 'ending', 'ended'))): ?>
              <i class="icon <?=$status?>"></i>
              <?php else: ?>
              <i class="icon icon-grey"></i>
              <?php endif; ?>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- 最新资讯 -->
    <div class="container mt-5 mt-lg-7 pb-4 home-news">
      <div class="htitle text-center">
        <span></span>
        <h1><?=__('最新资讯', 'young-bird')?></h1>
      </div>
      <div class="mb-5 list-news-container">
        <div class="list-news">
          <div class="order-2 order-md-1 col-sm-8 col-md-3-11 column-left">
            <?php foreach (get_posts(array ('category_name' => 'home-secondary', 'posts_per_page' => 6)) as $index => $post): if ($index % 2 === 1) continue; ?>
            <a href="<?=get_the_permalink($post->ID)?>" class="card link">
              <div>
              <?=get_the_post_thumbnail($post->ID, 'vga', array ('class' => 'card-img-top'))?>
              </div>
              <div class="card-body">
                <div class="title text-truncate"><?=get_the_title($post->ID)?><br><?=get_the_subtitle($post->ID)?></div>
                <div class="label text-truncate"># <?=get_post_meta( $post->ID,'front_tag',true)?></div>
                <p class="text-truncate"><?=get_the_excerpt($post->ID)?></p>

              </div>
            </a>
            <?php endforeach; ?>
          </div>
          <div class="order-1 order-md-2 col-sm-8 col-md-5-11 column-middle">
            <?php $total_primary = count(get_posts(array ('category_name' => 'home-primary', 'posts_per_page' => -1))); foreach (get_posts(array ('category_name' => 'home-primary', 'posts_per_page' => 2)) as $post): ?>
            <a href="<?=get_the_permalink($post->ID)?>" class="card link">
              <div>
              <?=get_the_post_thumbnail($post->ID, 'vga', array ('class' => 'card-img-top'))?>
              </div>
              <div class="card-body">
                <div class="title text-truncate"><?=get_the_title($post->ID)?><br><?=get_the_subtitle($post->ID)?></div>
                <div class="label text-truncate"># <?=get_post_meta( $post->ID,'front_tag',true)?></div>
                <p class="text-truncate"><?=get_the_excerpt($post->ID)?></p>

              </div>
            </a>
            <?php endforeach; ?>
          </div>
          <div class="order-3 order-md-3 col-sm-8 col-md-3-11 column-right">
            <?php $total_secondary = count(get_posts(array ('category_name' => 'home-secondary', 'posts_per_page' => -1))); foreach (get_posts(array ('category_name' => 'home-secondary', 'posts_per_page' => 6)) as $index => $post): if ($index % 2 === 0) continue; ?>
              <a href="<?=get_the_permalink($post->ID)?>" class="card link">
                <div>
                <?=get_the_post_thumbnail($post->ID, 'vga', array ('class' => 'card-img-top'))?>
                </div>
                <div class="card-body">
                  <div class="title text-truncate"><?=get_the_title($post->ID)?><br><?=get_the_subtitle($post->ID)?></div>
                  <div class="label text-truncate">#<?=get_post_meta($post->ID,'front_tag',true)?></div>
                  <p class="text-truncate"><?=get_the_excerpt($post->ID)?></p>

                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php if ($total_primary > 2 || $total_secondary > 12): ?>
      <a href="#" class="btn btn-outline-primary mx-auto d-block btn-common btn-loadmore" data-base-url-primary="<?=pll_home_url()?>category/home-primary<?=language_slug_suffix()?>/" data-base-url-secondary="<?=pll_home_url()?>category/home-secondary<?=language_slug_suffix()?>/"><?=__('发现更多', 'young-bird')?></a>
      <?php endif; ?>
    </div>

<?php get_footer(); ?>
