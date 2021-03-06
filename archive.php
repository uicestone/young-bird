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
    <div class="container mt-4 mt-lg-7 pb-4 pubu">
      <!-- Filter -->
      <div class="category-container d-flex flex-wrap mb-4 row">
        <a href="?tag=" class="<?=!$_GET['tag'] ? 'active' : ''?>"><?=__('全部', 'young-bird')?></a>
        <?php foreach (get_tags() as $tag): ?>
        <?php if($tag->term_id!=29&&$tag->term_id!=362):?>
        <a href="?tag=<?=$tag->slug?>" class="text-truncate <?=$_GET['tag'] === urldecode($tag->slug) ? 'active' : ''?>" title="<?=$tag->name?>"><?=$tag->name?></a>
        <?php endif;?>
          <?php endforeach; ?>
      </div>
      <div class="row">
        <div class="col-md-18">
          <div class="row pubu-list">
            <?php while (have_posts()): the_post(); ?>
            <div class="col-md-12">
              <div class="card mb-4 item-history item-history-no-action">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('vga', array('class' => 'card-img-top'))?>
                </a>
                <div class="card-body mt-4">
                  <div class="row head justify-content-between align-items-center">
                    <span class="color-cyan hashtag"># <?=strip_tags(get_the_tag_list('', '、', '', $post->ID))?></span>
                    <div>
                      <?php foreach (get_the_terms(get_the_ID(), 'news_category') ?: array() as $term): ?>
                      <i class="tag tag-grey" style="background: <?=get_field('color', $term)?>"><?=$term->name?></i>
                      <?php endforeach; ?>
                    </div>
                  </div>
                  <h3 class="mt-3"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h3>
                  <p class="color-silver"><?=$post->post_excerpt?></p>
                  <div class="action"></div>
                </div>
              </div>
            </div>
            <?php endwhile; ?>
          </div>
          <?php if ($wp_query->max_num_pages > 1): ?>
          <button type="button" class="btn btn-outline-primary mx-auto d-block btn-common mb-4 btn-loadmore" data-base-url="<?=pll_home_url()?>category/news<?=language_slug_suffix()?>/"><?=__('发现更多', 'young-bird')?></button>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <?php foreach (get_posts(array ('category_name' => 'news-list-ad', 'posts_per_page' => 100)) as $ad): ?>
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
<?php get_footer(); elseif (preg_match('/^home-/', $wp_query->query['category_name'])): while (have_posts()): the_post(); ?>
<a href="<?php the_permalink()?>" class="card link">
  <div>
    <?php the_post_thumbnail($_GET['partial'] === 'primary' ? '5-4' : 'vga' , array('class' => 'card-img-top'))?>
  </div>
  <div class="card-body">
    <div class="title text-truncate">
      <?php the_title()?>
    </div>
    <div class="label text-truncate">#<?=get_post_meta($post->ID,'front_tag',true)?></div>
    <p class="text-truncate">
      <?php the_excerpt()?>
    </p>

  </div>
</a>
<?php endwhile; else: ?>
  <?php while (have_posts()): the_post(); ?>
  <div class="col-md-12">
    <div class="card mb-4 item-history item-history-no-action">
      <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail('vga', array('class' => 'card-img-top'))?>
      </a>
      <div class="card-body mt-4">
        <div class="row head justify-content-between align-items-center">
          <span class="color-cyan hashtag"># <?=strip_tags(get_the_tag_list('', '、', '', $post->ID))?></span>
          <div>
            <?php foreach (get_the_terms($post->ID, 'news_category') ?: array() as $term): ?>
            <i class="tag tag-grey" style="background: <?=get_field('color', $term)?>"><?=$term->name?></i>
            <?php endforeach; ?>
          </div>
        </div>
        <h3 class="mt-3"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h3>
        <p class="color-silver"><?=$post->post_excerpt?></p>
        <div class="action"></div>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
<?php endif; ?>
