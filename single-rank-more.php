
<?php $mengbna=get_post_meta(get_the_ID(),'user_mengban',true);

        $xiangqing=get_post_meta(get_the_ID(),'ruse_detail',true);
  $mengban_start_time=get_post_meta(get_the_ID(),'mengban_start_time',true);
$mengban_end_time=get_post_meta(get_the_ID(),'mengban_end_time',true);
if(!$mengban_end_time)
    $mengban_end_time=1000000000000;
if(!$mengban_start_time)
    $mengban_start_time=0;

;?>
<?php $event_id = get_post_meta(get_the_ID(), 'event', true);



?>

<style type=text/css >
    .fancybox-image-wrap:after
    {
        content:url(<?php echo wp_get_attachment_image( get_post_meta($event_id,'water',true));?>);
    }
</style>
<?php get_header(); ?>
    <!-- Body -->
    <div class="container mt-4 mt-md-5 pb-4 pb-md-6 toplist-container">
      <h1 class="text-center color-dark-yellow">
        <?php if($is_participate_round = get_post_meta(get_the_ID(), 'is_participate_round', true)): ?>
            <?=__('入围', 'young-bird')?>
        <?php else: ?>
        TOP<?=$rank_length?>
        <?php endif; ?>
        <?php if (current_user_can('edit_users')): ?>
          <small>
            <a href="#" class="remind-rank-published btn btn-outline-primary btn-sm"><?=__('通知选手', 'young-bird')?></a>
          </small>
        <?php endif; ?>
      </h1>
        <?php if($mengbna==true):?>

            <?php if(pll_current_language()=='zh'):?>
                <h6 style="font-size: 13px;font-family: 微软雅黑;padding-top: 16px;color: blue;?> ">
            <?=__('出于保护参赛选手作品知识产权的目的，避免恶意复制抢注等侵权行为，主办方现阶段只展示入围名单，暂不对外公开作品细节。', 'young-bird')?>
                </h6>
            <?php else:?>
                <h6 style="font-size: 13px;font-family: SFMono-Regular;padding-top: 16px;color: blue;?> ">
                In protection of copyright and avoid piracy, we here only release shortlist instead of design details.
        </h6>
            <?php endif;?>

        <?php endif;?>
      <div class="row mt-4 mt-md-5">
        <?php foreach ($works as $work): ?>
        <div class="col-sm-12 col-md-6 col-lg-2-4 mb-2 mb-md-4">
          <div class="card mb-4 item-history item-top50  <?php if(!($xiangqing==1)) echo 'item-work';?> ">
            <div style="height:165px">

                <?php if($mengbna!=true):?>
                <?php    $time=time();

                if(($time>$mengban_start_time&&$time<$mengban_end_time)): ?>

                         <?=get_the_post_thumbnail($work->ID, 'vga', array('class' => 'card-img-top', 'style' => 'height: 100%; object-fit: cover;'))?>
                <?php else:?>
                    <div class="card-img-top" style="height: 100%;object-fit: cover;background-image: url(<?=get_the_post_thumbnail_url($work->ID, 'vga', array('width' => '100%'));?>);">




                        <?=wp_get_attachment_image( get_post_meta(get_the_ID(),'mengban_image',true), 'vga', false,array('class' => 'card-img-top img ', 'style' => 'max-width:100%;height: 165px; object-fit: cover;opacity:0.8;'))?>



                    </div>
                <?php endif;?>
            <?php else:?>




              <div class="card-img-top" style="height: 100%;object-fit: cover;background-image: url(<?=get_the_post_thumbnail_url($work->ID, 'vga', array('width' => '100%'));?>);">



                  <?=wp_get_attachment_image( get_post_meta(get_the_ID(),'mengban_image',true), 'vga', false,array('class' => 'card-img-top img ', 'style' => 'max-width:100%;height: 165px; object-fit: cover;opacity:0.8;'))?>


              </div>


            <?php endif;?>

            </div>
            <div class="card-body mt-4">
              <div class="head justify-content-between align-items-center">
                <div class="label color-black font-weight-bold text-truncate"><?=get_the_title($work->ID)?></div>
                <div>YB<?=strtoupper($work->post_name)?></div>
              </div>
              <p class="pt-3 text-truncate"><?=get_post_meta($work->ID, 'description', true)?></p>
              <div class="action row align-items-center">
                <!--<i class="fas fa-eye mr-1"></i>-->
                <!--<span class="mr-2">921</span>-->
                <?php if ($public_voting): ?>
                <span class="like-box">
                  <i class="<?=in_array($work->ID, get_user_meta(get_current_user_id(), 'vote_works') ?: array()) ? 'fas ' : 'far'?> fa-heart like mr-1" data-post-link="<?=get_the_permalink($work->ID)?>"></i>
                  <span class="mr-2 likes"><?=get_post_meta($work->ID, 'votes', true) ?: 0?></span>
                </span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php
          $comments = get_post_meta($work->ID, 'comments', true) ?: array();
          foreach($comments as &$comment) {
            if (empty($comment['avatar'])) {
              $comment['avatar'] = get_user_meta($comment['judge'], 'avatar', true);
            }
            if (empty($comment['time'])) {
              $comment['time'] = '';
            }
          }
          ?>
          <div class="d-none" data-comments='<?=json_encode($comments, JSON_UNESCAPED_UNICODE)?>'>
            <!-- 作品简介 -->
            <a class="w-100" style="padding:10vh 20vw">
              <div class="row mx-auto justify-content-between">
                <h3><?=get_the_title($work->ID)?></h3>
                <h4>YB<?=strtoupper($work->post_name)?></h4>
              </div>
              <p class="mt-3"><?=get_post_meta($work->ID, 'description', true)?></p>
            </a>
            <!-- 图集 -->
            <?php foreach (get_post_meta($work->ID, 'images') ?: array() as $image_url): ?>
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

<script>
    //方法一
    function noMenuOne()
    {

        return false;
    }
    document.oncontextmenu = noMenuOne;
    //方法二

</script>