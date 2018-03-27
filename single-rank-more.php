<?php get_header(); ?>
    <!-- Body -->
    <div class="container mt-4 mt-md-5 pb-4 pb-md-6 toplist-container">
      <h1 class="text-center color-dark-yellow">TOP<?=$rank_length?></h1>
      <div class="row mt-4 mt-md-5">
        <?php foreach ($works as $work): ?>
        <div class="col-sm-12 col-md-6 col-lg-2-4 mb-2 mb-md-4">
          <div class="card mb-4 item-history item-top50 item-work">
            <?=get_the_post_thumbnail($work->ID, 'vga', array('class' => 'card-img-top'))?>
            <div class="card-body mt-4">
              <div class="row head justify-content-between align-items-center">
                <div class="label color-black font-weight-bold text-truncate col-18"><?=get_the_title($work->ID)?></div>
                <div>YB<?=strtoupper($work->post_name)?></div>
              </div>
              <p class="pt-3 text-truncate"><?=get_post_meta($work->ID, 'description', true)?></p>
              <div class="action row align-items-center">
                <!--<i class="fas fa-eye mr-1"></i>-->
                <!--<span class="mr-2">921</span>-->
                <?php if ($public_voting): ?>
                <i class="<?=in_array($work->ID, get_user_meta(get_current_user_id(), 'vote_works') ?: array()) ? 'fas ' : 'far'?> fa-heart like mr-1" data-post-link="<?=get_the_permalink($work->ID)?>"></i>
                <span class="mr-2 likes"><?=get_post_meta($work->ID, 'votes', true) ?: 0?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="d-none" data-comments="<?=json_encode(get_post_meta($work->ID, 'comment'), JSON_UNESCAPED_UNICODE)?>">
            <!-- 作品简介 -->
            <a class="w-100" style="padding:10vh 20vw">
              <div class="row mx-auto justify-content-between">
                <h3><?=get_the_title($work->ID)?></h3>
                <h4>YB<?=strtoupper($work->post_name)?></h4>
              </div>
              <p class="mt-3"><?=get_post_meta($work->ID, 'description', true)?></p>
            </a>
            <!-- 图集 -->
            <?php foreach (get_post_meta($work->ID, 'images') as $image_url): ?>
            <a href="<?=$image_url?>">
              <img src="" alt="" />
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <!--<button type="button" class="btn btn-outline-primary mx-auto d-block btn-common mb-4">--><?//=__('发现更多', 'young-bird')?><!--</button>-->
    </div>
<?php get_footer(); ?>
