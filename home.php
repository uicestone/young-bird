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
      <div class="category mb-4">
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
      <a href="/event/" class="btn btn-outline-secondary mx-auto d-block btn-common">发现更多</a>
      <div class="row justify-content-between list-competiton mt-4">
        <?php foreach (get_posts(array ('post_type' => 'event', 'category_name' => 'home-primary', 'posts_per_page' => 4)) as $event): ?>
        <div class="col-md-12 col-lg-6 mb-4">
          <a href="#" class="card link">
            <?=get_the_post_thumbnail($event->ID, '8-7', array ('class' => 'card-img-top'))?>
            <div class="card-body mt-4">
              <h5><?=get_the_title($event->id)?></h5>
              <h5></h5>
              <span>截止日期/<?=get_post_meta($event->ID, 'start_date', true)?> ~ <?=get_post_meta($event->ID, 'end_date', true)?></span>
              <i class="icon icon-yellow"></i>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- 最新资讯 -->
    <div class="container mt-7 pb-4">
      <div class="htitle text-center">
        <span></span>
        <h1>最新资讯</h1>
      </div>
      <div class="list-news mb-5">
        <div class="order-sm-2 order-md-1 col-md-3-11 column-left">
          <a href="#" class="card link">
            <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/home-news.jpg" alt="Card image cap">
            <div class="card-body">
              <div class="title text-truncate">
                坂雪岗科技城核心区
                <br>
                城市品质提升国际设计大赛
              </div>
              <div class="label text-truncate">#城市规划设计、建筑、景观设计</div>
              <p class="text-truncate">
                深圳，中国
                <br>
                报名截止日期：
                <br>
                2017年11月17日15：00
              </p>
              <i class="tag tag-green">新闻</i>
            </div>
          </a>
        </div>
        <div class="order-sm-1 order-md-2 col-md-5-11 column-middle">
          <a href="#" class="card link">
            <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-xl.jpg" alt="Card image cap">
            <div class="card-body">
              <div class="title text-truncate">
                坂雪岗科技城核心区
                <br>
                城市品质提升国际设计大赛
              </div>
              <div class="label text-truncate">#城市规划设计、建筑、景观设计</div>
              <p class="text-truncate">
                主办方：深圳，中国
                <br>
                深圳，中国
                <br>
                报名截止日期：
                <br>
                2017年11月17日15：00
              </p>
              <i class="tag tag-orange">竞赛</i>
            </div>
          </a>
        </div>
        <div class="order-sm-3 order-md-3 col-md-3-11 column-right">
          <a href="#" class="card link">
            <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/home-news.jpg" alt="Card image cap">
            <div class="card-body">
              <div class="title text-truncate">
                坂雪岗科技城核心区
                <br>
                城市品质提升国际设计大赛
              </div>
              <div class="label text-truncate">#城市规划设计、建筑、景观设计</div>
              <p class="text-truncate">
                深圳，中国
                <br>
                报名截止日期：
                <br>
                2017年11月17日15：00
              </p>
              <i class="tag tag-green">新闻</i>
            </div>
          </a>
        </div>
      </div>
      <a href="#" class="btn btn-outline-secondary mx-auto d-block btn-common">发现更多</a>
    </div>

<?php get_footer(); ?>
