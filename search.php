<?php get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-search.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_搜 索 <br>SEARCH RESULTS</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-6">
      <!-- 搜索框 -->
      <div class="row mb-5">
        <div class="col-md-9">
          <form>
            <div class="input-group input-group-lg">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
              </div>
              <input type="text" name="s" value="<?=$_GET['s']?>" class="form-control" placeholder="">
              <button type="submit" style="padding:0 1rem">搜索</button>
            </div>
          </form>
        </div>
      </div>
      <!-- 新闻搜索结果 -->
      <div class="row mx-auto mb-2 justify-content-between">
        <h2><?=__('新闻：', 'young-bird')?></h2>
        <h2><?=__('总共：', 'young-bird')?><?=count(get_posts(array('category_name' => 'news', 's' => $_GET['s'], 'posts_per_page' => -1)))?></h2>
      </div>
      <div class="row mt-3 mb-2">
        <?php foreach ($posts = get_posts(array('category_name' => 'news', 's' => $_GET['s'])) as $post): ?>
        <div class="col-md-8">
          <a href="<?=get_the_permalink($post->ID)?>" class="card mb-4 item-history item-history-no-action link">
            <?=get_the_post_thumbnail($post->ID, 'vga', array('class' => 'card-img-top'))?>
            <div class="card-body mt-4">
              <div class="row head justify-content-between align-items-center">
                <span class="color-cyan hashtag"># <?=strip_tags(get_the_tag_list('', '、', '', $post->ID))?></span>
                <div>
                  <?php foreach (get_the_terms($post->ID, 'news_category') ?: array() as $term): ?>
                  <i class="tag tag-grey" style="background: <?=get_field('color', $term)?>"><?=$term->name?></i>
                  <?php endforeach; ?>
                </div>
              </div>
              <h3 class="mt-3"><?=get_the_title($post->ID)?><br><?=get_the_subtitle($post->ID)?></h3>
              <p><?=get_the_excerpt($post->ID)?></p>
              <div class="action"></div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
      <a href="<?=pll_home_url()?>/news/" class="btn btn-outline-primary mx-auto d-block btn-common"><?=__('发现更多', 'young-bird')?></a>
      <!-- 竞赛搜索结果 -->
      <div class="row mx-auto mt-5 mb-2 justify-content-between">
        <h2><?=__('竞赛：', 'young-bird')?></h2>
        <h2><?=__('总共：', 'young-bird')?><?=count(get_posts(array('post_type' => 'event', 's' => $_GET['s'], 'posts_per_page' => -1)))?></h2>
      </div>
      <div class="row mt-3 mb-2">
        <?php foreach ($events = get_posts(array('post_type' => 'event', 's' => $_GET['s'])) as $event): ?>
        <div class="col-md-8">
          <a href="<?=get_the_permalink($event->ID)?>" class="card mb-4 item-history link">
            <?=get_the_post_thumbnail($event->ID, 'vga', array('class' => 'card-img-top'))?>
            <div class="card-body mt-4">
              <div class="row head justify-content-between align-items-center">
                <div class="labels">
                  <?php if ($event_category = get_the_terms($event->ID, 'event_category')): foreach ($event_category as $term): ?>
                  <b class="label color-grey" style="color: <?=get_field('color', $term)?>"><?=$term->name?></b>
                  <?php endforeach; endif; ?>
                </div>
                <div><?=get_post_meta($event->ID, 'start_date', true)?> ~ <?=get_post_meta(get_the_ID(), 'end_date', true)?></div>
              </div>
              <h3 class="mt-3"><?=get_the_title($event->ID)?><br><?=get_the_subtitle($event->ID)?></h3>
              <p class="color-black mb-4"><?=get_post_meta($event->ID, 'organizer', true)?></p>
              <p><?=get_the_excerpt($event->ID)?></p>
              <div class="action row align-items-center">
                <i class="far fa-user mr-2"></i>
                <span class="mr-4"><?=__('参赛人数', 'young-bird')?> / <?=get_post_meta($event->ID, 'attendees', true) ?: 0?></span>
                <i class="far fa-heart"></i>
              </div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
      <a href="<?=pll_home_url()?>event/" class="btn btn-outline-primary mx-auto d-block btn-common"><?=__('发现更多', 'young-bird')?></a>
    </div>
<?php get_footer(); ?>
