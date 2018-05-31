<?php
redirect_login();
$event_id = $_GET['event_id'];
$event_status = get_post_meta($event_id, 'status', true);
get_header(); ?>
    <!-- Banner -->
    <!-- for desktop -->
    <div class="container-fluid px-0 d-none d-lg-block">
      <img src="<?=get_field('banner_desktop', $event_id)['url']?>" width="100%" alt="">
    </div>
    <!-- for pad -->
    <div class="container-fluid px-0 d-none d-md-block d-lg-none">
      <img src="<?=get_field('banner_pad', $event_id)['url']?>" width="100%" alt="">
    </div>
    <!-- for smart phone -->
    <div class="container-fluid px-0 d-md-none">
      <img src="<?=get_field('banner_phone', $event_id)['url']?>" width="100%" alt="">
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-6">
      <h1>
        <?=__('作品列表', 'young-bird')?> /
        <small>
          <?=$wp_query->found_posts . ' ' . __('个作品', 'young-bird')?> /
          <?php if (current_user_can('edit_user') && $_GET['stage'] === 'rating'):
            $meta_db_result_score = $wpdb->get_results("select meta_value from wp_postmeta where meta_key = 'score'");
            $works_scores = array_map('unserialize', array_column($meta_db_result_score, 'meta_value'));
            $works_score_count = array_map('count', array_column($meta_db_result_score, 'meta_value'));
            $total_score_count = array_sum($works_score_count);
            $judge_count = count(get_field('judges', $event_id)); ?>
          <?=__('评委评分进度：', 'young-bird')?><?=round($total_score_count/($judge_count * $wp_query->found_posts) * 100, 1)?>%
          <?php else: ?>
          <?=count(get_posts(array('post_type' => 'work', 'posts_per_page' => -1, 'lang' => '', 'meta_query' => array(
            array('key' => 'event', 'value' => pll_get_post($event_id, pll_default_language())),
            array('key' => 'score_' . get_current_user_id(), 'compare' => 'EXISTS')
          )))) . __('个已评分', 'young-bird')?>
          <?php endif; ?>
        </small>
      </h1>
      <div class="row mt-5 review-list">
        <?php while (have_posts()): the_post(); ?>
        <div class="col-sm-12 col-md-8 col-lg-2-4 mb-4">
          <div class="card mb-4 item-review" id="yb<?=$post->post_name?>" data-url="<?=get_the_permalink($post->ID)?>">
            <div class="card-img-container">
              <?php the_post_thumbnail('medium-sq', array ('class' => 'card-img-top')); ?>
            </div>
            <div class="card-body mt-4">
              <h5 class="color-black text-center">YB<?=strtoupper($post->post_name)?></h5>
              <?php if (isset($_GET['stage']) && $_GET['stage'] === 'rating'): ?>
              <h3 class="mb-0 text-center">
                <?php if ($score = get_post_meta(get_the_ID(), 'score_' . get_current_user_id(), true)): ?>
                <?php if ($event_status === 'second_judging') { $score = floor($score / 100); } ?>
                <?=__('分数：', 'young-bird') . $score?>
                <?php else: ?>
                <?=__('待处理', 'young-bird')?>
                <?php endif; ?>
              </h3>
              <?php else: ?>
              <h3 class="mb-0 text-center">
                <?php if ($status = get_post_meta(get_the_ID(), 'status', true)): ?>
                <?=__('入围', 'young-bird')?>
                <?php elseif ($status === '0'): ?>
                <?=__('不入围', 'young-bird')?>
                <?php else: ?>
                <?=__('待处理', 'young-bird')?>
                <?php endif; ?>
              </h3>
              <?php endif; ?>
            </div>
          </div>
          <?php $my_score = get_post_meta(get_the_ID(), 'score_' . get_current_user_id(), true);
          if ($event_status === 'second_judging') { $my_score = floor($my_score / 100); } ?>
          <div class="d-none"
               data-comments='<?=json_encode(get_post_meta(get_the_ID(), 'comments', true), JSON_UNESCAPED_UNICODE)?>'
               data-my-comment="<?=get_post_meta(get_the_ID(), 'comment_' . get_current_user_id(), true)?>"
               data-my-score="<?=$my_score?>">
            <a class="w-100" style="padding:10vh 20vw">
              <div class="row mx-auto justify-content-between">
                <h3><?php the_title(); ?></h3>
                <h4><?=strtoupper($post->post_name)?></h4>
              </div>
              <p class="mt-3">
                <?=get_post_meta($post->ID, 'description', true)?>
              </p>
            </a>
            <a href="<?=get_the_post_thumbnail_url(get_the_ID(), 'full')?>">
              <img src="" alt="" />
            </a>
            <?php foreach (get_post_meta(get_the_ID(), 'images') as $image): ?>
            <a href="<?=$image?>">
              <img src="" alt="" />
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
      <nav class="mt-5">
        <?=paginate_links(array ('type' => 'list', 'prev_text' => '<i class="fas fa-angle-left"></i>', 'next_text' => '<i class="fas fa-angle-right"></i>'))?>
      </nav>
    </div>
<?php get_footer(); ?>
