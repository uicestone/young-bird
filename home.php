<?php get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid px-0 banner-home owl-carousel owl-theme">
      <?php foreach (get_posts(array('category_name' => 'home-banner')) as $banner): ?>
      <a href="<?=get_the_permalink($banner->ID)?>">
        <!-- for desktop -->
        <div class="container-fluid px-0 d-none d-lg-block">
          <?=get_the_post_thumbnail($banner->ID, 'movie', array('width'=>'100%'))?>
        </div>
        <!-- for pad -->
        <div class="container-fluid px-0 d-none d-md-block d-lg-none">
          <?=get_the_post_thumbnail($banner->ID, 'movie', array('width'=>'100%'))?>
        </div>
        <!-- for smart phone -->
        <div class="container-fluid px-0 d-md-none">
          <?=get_the_post_thumbnail($banner->ID, 'movie', array('width'=>'100%'))?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <!-- 热门竞赛 -->
    <div class="container mt-7">
      <div class="htitle text-center">
        <span></span>
        <h1>热门竞赛</h1>
      </div>
      <div class="category home-event-status mb-4">
        <div class="row justify-content-center">
          <div class="d-flex align-items-center mx-3 mb-2">
            <i class="icon icon-yellow mr-3"></i>
            <span>即将开始</span>
          </div>
          <div class="d-flex align-items-center mx-3 mb-2">
            <i class="icon icon-pink mr-3"></i>
            <span>开始报名</span>
          </div>
          <div class="d-flex align-items-center mx-3 mb-2">
            <i class="icon icon-rose mr-3"></i>
            <span>即将截止</span>
          </div>
          <div class="d-flex align-items-center mx-3 mb-2">
            <i class="icon icon-red mr-3"></i>
            <span>报名截止</span>
          </div>
        </div>
      </div>
      <a href="<?=site_url()?>/event/" class="btn btn-outline-primary mx-auto d-block btn-common">发现更多</a>
      <div class="row justify-content-between list-competiton mt-4">
        <?php foreach (get_posts(array ('post_type' => 'event', 'category_name' => 'home-primary', 'posts_per_page' => 4)) as $event): ?>
        <div class="col-md-12 col-lg-6 mb-4">
          <a href="<?=get_the_permalink($event->ID)?>" class="card link">
            <?=get_the_post_thumbnail($event->ID, 'medium-sq', array ('class' => 'card-img-top'))?>
            <div class="card-body mt-4">
              <h5 class="text-truncate" title="<?=get_the_title($event->ID)?>"><?=get_the_title($event->ID)?></h5>
              <h5 class="text-truncate"><?=get_the_subtitle($event->ID)?></h5>
              <span class="end-date">截止日期/<?=get_post_meta($event->ID, 'end_date', true)?></span>
              <i class="icon icon-yellow"></i>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- 最新资讯 -->
    <div class="container mt-7 pb-4 home-news">
      <div class="htitle text-center">
        <span></span>
        <h1>最新资讯</h1>
      </div>
      <div class="list-news mb-5">
        <div class="order-sm-2 order-md-1 col-md-3-11 column-left">
          <?php foreach (get_posts(array ('category_name' => 'home-secondary', 'posts_per_page' => 6)) as $index => $post): if ($index % 2 === 1) continue; ?>
          <a href="<?=get_the_permalink($post->ID)?>" class="card link">
            <?=get_the_post_thumbnail($post->ID, 'vga', array ('class' => 'card-img-top'))?>
            <div class="card-body">
              <div class="title text-truncate"><?=get_the_title($post->ID)?><br><?=get_the_subtitle($post->ID)?></div>
              <div class="label text-truncate">#</div>
              <p class="text-truncate"><?=get_the_excerpt($post->ID)?></p>
              <?php foreach (get_the_tags($post->ID) ?: array() as $tag): ?>
              <i class="tag tag-grey" style="background: <?=get_field('color', $tag)?>"><?=$tag->name?></i>
              <?php endforeach; ?>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
        <div class="order-sm-1 order-md-2 col-md-5-11 column-middle">
          <?php foreach (get_posts(array ('category_name' => 'home-primary', 'posts_per_page' => 2)) as $post): ?>
          <a href="<?=get_the_permalink($post->ID)?>" class="card link">
            <?=get_the_post_thumbnail($post->ID, '5-4', array ('class' => 'card-img-top'))?>
            <div class="card-body">
              <div class="title text-truncate"><?=get_the_title($post->ID)?><br><?=get_the_subtitle($post->ID)?></div>
              <div class="label text-truncate">#</div>
              <p class="text-truncate"><?=get_the_excerpt($post->ID)?></p>
              <?php foreach (get_the_tags($post->ID) ?: array() as $tag): ?>
                <i class="tag tag-grey" style="background: <?=get_field('color', $tag)?>"><?=$tag->name?></i>
              <?php endforeach; ?>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
        <div class="order-sm-3 order-md-3 col-md-3-11 column-right">
          <?php foreach (get_posts(array ('category_name' => 'home-secondary', 'posts_per_page' => 6)) as $index => $post): if ($index % 2 === 0) continue; ?>
            <a href="<?=get_the_permalink($post->ID)?>" class="card link">
              <?=get_the_post_thumbnail($post->ID, 'vga', array ('class' => 'card-img-top'))?>
              <div class="card-body">
                <div class="title text-truncate"><?=get_the_title($post->ID)?><br><?=get_the_subtitle($post->ID)?></div>
                <div class="label text-truncate">#城市规划设计、建筑、景观设计</div>
                <p class="text-truncate"><?=get_the_excerpt($post->ID)?></p>
                <?php foreach (get_the_tags($post->ID) ?: array() as $tag): ?>
                  <i class="tag tag-grey" style="background: <?=get_field('color', $tag)?>"><?=$tag->name?></i>
                <?php endforeach; ?>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <a href="#" class="btn btn-outline-primary mx-auto d-block btn-common btn-loadmore">发现更多</a>
    </div>

<?php get_footer(); ?>
