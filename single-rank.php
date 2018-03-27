<?php
$rank_length = get_post_meta(get_the_ID(), 'length', true);
$event_id = get_post_meta(get_the_ID(), 'event', true);
$event_status = get_post_meta($event_id, 'status', true);
$works = array_map(function ($work_id) {
  return get_post($work_id);
}, get_post_meta(get_the_ID(), 'works', true));
$stage = get_field('stage');
$public_vote_start = get_field('voting_start_at');
$public_vote_stop = get_field('voting_stop_at');
$public_voting = $stage === 'public_vote' && time() >= strtotime($public_vote_start) && time() <= strtotime($public_vote_stop) ;
$ranking_judge = get_field('ranking_judge');

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

<?php if ($rank_length > 10):
      include(locate_template('single-rank-more.php'));
    else: ?>
    <!-- Body -->
    <div class="container mt-4 mt-md-5 pb-4 pb-md-6 toplist-container">
      <h1 class="text-center color-dark-yellow">TOP<?=$rank_length?></h1>
      <?php foreach ($works as $index => $work): ?>
      <div class="mt-4 mt-md-5">
        <div class="row item-work item-top3-container">
          <div class="col-sm-12 mb-4 mb-md-0">
            <?=get_the_post_thumbnail($work->ID, 'vga', array('width' => '100%'))?>
          </div>
          <div class="col-sm-12 order-sm-first card item-top3">
            <div class="card-body pb-5">
              <div class="row head justify-content-between align-items-center">
                <div class="label color-dark-yellow font-weight-bold col-12">
                  <?php if ($ranking_judge && $index === 0): ?>
                  <span>CHAMPION</span>
                  <?php elseif ($ranking_judge): ?>
                  <span>TOP <?=$index+1?></span>
                  <?php else: ?>
                  <span>TOP<?=$rank_length?></span>
                  <?php endif; ?>
                </div>
                <div class="color-black">YB<?=strtoupper($work->post_name)?></div>
                <?php if ($event_status === 'second_judging' && $work->post_author == get_current_user_id()): ?>
                  <div>
                    <a href="<?=get_the_permalink($work->ID)?>" class="btn btn-outline-primary btn-common"><?=__('修改作品', 'young-bird')?></a>
                  </div>
                <?php endif; ?>
              </div>
              <h3 class="mt-3"><?=get_the_title($work->ID)?></h3>
              <?=wpautop(get_post_meta($work->ID, 'description', true))?>
              <div class="action row align-items-center">
                <!--<i class="fas fa-eye mr-2"></i>-->
                <!--<span class="mr-4">921</span>-->
                <?php if ($public_voting): ?>
                <i class="<?=in_array($work->ID, get_user_meta(get_current_user_id(), 'vote_works') ?: array()) ? 'fas ' : 'far'?> fa-heart like mr-2" data-post-link="<?=get_the_permalink($work->ID)?>"></i>
                <span class="mr-4 likes"><?=get_post_meta($work->ID, 'votes', true) ?: 0?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="d-none" data-comments="<?=json_encode(get_post_meta($work->ID, 'comment'), JSON_UNESCAPED_UNICODE)?>">
          <a class="w-100" style="padding:10vh 20vw">
            <div class="row mx-auto justify-content-between">
              <h3><?=get_the_title($work->ID)?></h3>
              <h4>YB<?=strtoupper($work->post_name)?></h4>
            </div>
            <p class="mt-3"><?=get_post_meta($work->ID, 'description', true)?></p>
          </a>
          <?php foreach (get_post_meta($work->ID, 'images') as $image_url): ?>
          <a href="<?=$image_url?>">
            <img src="" alt="" />
          </a>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
<?php endif;
get_footer();
