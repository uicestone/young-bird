<?php
header('Total-Pages: ' . $wp_query->max_num_pages);
if (!isset($_GET['partial'])):
get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-news.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_新 闻 <br>NEWS</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-4 pubu">
      <!-- Filter -->
      <div class="category-container d-flex flex-wrap mb-4 row">
        <a href="?tag=" class="col-md-2 <?=!$_GET['tag'] ? 'active' : ''?>">全部</a>
        <?php foreach (get_tags() as $tag): ?>
        <a href="?tag=<?=$tag->slug?>" class="col-md-2 text-truncate <?=$_GET['tag'] === urldecode($tag->slug) ? 'active' : ''?>" title="<?=$tag->name?>"><?=$tag->name?></a>
        <?php endforeach; ?>
      </div>
      <div class="row">
        <div class="col-md-18">
          <div class="row pubu-list">
            <?php while (have_posts()): the_post(); ?>
            <div class="col-md-12">
              <div class="card mb-4 item-history item-history-no-action">
                  <a href="<?php the_permalink(); ?>"><img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-history.jpg" alt="Card image cap"></a>
                <div class="card-body mt-4">
                  <div class="row head justify-content-between align-items-center">
                    <span class="color-cyan hashtag">#<?php the_tags(); ?></span>
                    <div class="tag tag-blue">-标签位置-</div>
                  </div>
                  <h3 class="mt-3"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h3>
                  <p><?php the_excerpt(); ?></p>
                  <div class="action"></div>
                </div>
              </div>
            </div>
            <?php endwhile; ?>
          </div>
          <button type="button" class="btn btn-outline-primary mx-auto d-block btn-common mb-4 btn-loadmore" data-name="news">发现更多</button>
        </div>
        <div class="col-md-6">
          <?php foreach (get_posts(array ('category_name' => 'news-list-ad', 'posts_per_page' => 2)) as $ad): ?>
          <a href="<?=get_the_permalink($ad)?>" class="card mb-3 item-sub-history">
            <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-history.jpg" alt="Card image cap">
            <div class="card-label">
              <span class="hashtag">#建筑设计</span>
              <div class="tag tag-blue">-标签位置-</div>
            </div>
            <hr />
            <div class="card-body">
              <h4><?=get_the_title($ad->ID)?><br><?=get_the_subtitle($ad->ID)?></h4>
              <p><?=get_the_excerpt($ad)?></p>
              <?php if ($ad_event = get_field('event', $ad)): ?>
              <p>截止日期：<?=get_post_meta($ad_event->ID, 'end_date', true)?></p>
              <?php endif; ?>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
<?php get_footer(); elseif (in_array($wp_query->query['category_name'], array ('home-primary', 'home-secondary'))): while (have_posts()): the_post(); ?>
<a href="<?php the_permalink()?>" class="card link">
  <?php the_post_thumbnail($_GET['partial'] === 'primary' ? '5-4' : 'vga' , array('class' => 'card-img-top'))?>
  <div class="card-body">
    <div class="title text-truncate">
      <?php the_title()?>
    </div>
    <div class="label text-truncate">#城市规划设计、建筑、观设计</div>
    <p class="text-truncate">
      <?php the_excerpt()?>
    </p>
    <?php if ($tags = get_the_tags()): foreach ($tags as $tag): ?>
    <i class="tag tag-orange"><?=$tag->name?></i>
    <?php endforeach; endif; ?>
  </div>
</a>
<?php endwhile; else: ?>
  <?php while (have_posts()): the_post(); ?>
  <div class="col-md-12">
    <div class="card mb-4 item-history item-history-no-action">
      <a href="<?php the_permalink(); ?>"><img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-history.jpg" alt="Card image cap"></a>
      <div class="card-body mt-4">
        <div class="row head justify-content-between align-items-center">
          <span class="color-cyan hashtag">#<?php the_tags(); ?></span>
          <div class="tag tag-blue">-标签位置-</div>
        </div>
        <h3 class="mt-3"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h3>
        <p><?php the_excerpt(); ?></p>
        <div class="action"></div>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
<?php endif; ?>
