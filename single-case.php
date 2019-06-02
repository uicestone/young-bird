<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2019-01-24
 * Time: 16:50
 */

$id_dl = pll_get_post(get_the_ID(), pll_default_language());
$like_posts = get_user_meta(get_current_user_id(), 'like_posts') ?: array();
if (isset($_POST['like'])) {
    redirect_login();
    $like = json_decode($_POST['like']);
    if ($like && !in_array($id_dl, $like_posts)) {
        add_user_meta(get_current_user_id(), 'like_posts', $id_dl);
        $likes = (get_post_meta($id_dl, 'like', true) ?: 0) + 1;
        update_post_meta($id_dl, 'like', $likes);
    }
    elseif (!$like && in_array($id_dl, $like_posts)) {

        delete_user_meta(get_current_user_id(), 'like_posts', $id_dl);
        $likes = (get_post_meta($id_dl, 'like', true) ?: 0) -1;
        update_post_meta($id_dl, 'like', $likes);
    }
    if(!$likes)
        $likes=0;
    echo $likes; exit;
}

$views = (get_post_meta($id_dl, 'views', true) ?: 0) + 1;
update_post_meta($id_dl, 'views', $views);
$likes = get_post_meta($id_dl, 'likes', true) ?: 0;

get_header();
?>



<div class="container-fluid bg-lighter-grey p-0">
    <div class="container case-outer-container case-detail-outer-container">
        <div class="row pubu">
            <div class="col-lg-18 col-md-24 case-inner-container">
                <div class="swiper-container cases_swiper">
                    <div class="swiper-wrapper">
                        <?php foreach(get_post_meta(get_the_ID(),'images') as $v):?>

                        <div class="swiper-slide">
                            <img class="img-fluid" src="<?php print wp_get_attachment_image_url($v['ID'],array('880,400'));?>" alt="">
                        </div>
                        <?php endforeach;?>
                    </div>
                    <!-- 如果需要分页器 -->
                    <div class="swiper-pagination"></div>

                    <!-- 如果需要导航按钮 -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
                <div class="swiper-container cases_thumbs">
                    <div class="swiper-wrapper">
                        <?php foreach(get_post_meta(get_the_ID(),'images') as $v):?>

                            <div class="swiper-slide">
                                <img class="img-fluid" src="<?php print wp_get_attachment_image_url($v['ID'],array('300','240'));?>" alt="">
                            </div>
                        <?php endforeach;?>

                    </div>
                    <div class="swiper_info">
                        <p>+<span><?php print count(get_post_meta(get_the_ID(),'images'));?></span></p>
                    </div>
                </div>
                <div class="case_detail_title">
                    <h2>   <?php print  get_the_title(); ?></h2>
                </div>
                <!-- 下面的和活动的share一样 -->
                <div class="justify-content-between align-items-center mt-2 mt-md-4 infos">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-eye mr-2"></i>
                        <span class="mr-4"><?=$views;?></span>
                        <span class="like-box">
                                  <i class="<?=in_array(pll_get_post(get_the_ID(), pll_default_language()), get_user_meta(get_current_user_id(), 'like_posts') ?: array()) ? 'fas ' : 'far'?> fa-heart like" data-post-link="<?=get_the_permalink(pll_get_post(get_the_ID(), pll_default_language()))?>"></i>
                                          <span class="mr-4 likes"><?php print (get_post_meta(pll_get_post(get_the_ID(), pll_default_language()),'like',true)?:0);?></span>
                            </span>
                        <?php if(get_post_meta(get_the_ID(),'event',true)!='null'):?>
                            <span><a href="<?=get_the_permalink(get_post_meta(get_the_ID(),'event',true));?>"><img src="/img/icon/reg.png"><?=__('报名', 'young-bird')?><a></span>
                        <?php endif;?>
                    </div>
                    <div class="d-none d-md-flex align-items-center share mt-3 mt-md-0" style="line-height:0">
                        <div class="share-container">
                            <?=__('分享', 'young-bird')?>
                        </div>
                    </div>
                </div>
                <!-- end -->
                <div class="case_detail_text">
                    <?php print get_post(get_the_ID())->post_content; ?>
                </div>
            </div>

            <div class="col-md-6 d-none d-lg-block">
                <?php foreach (get_posts(array ('category_name' => 'event-list-ad', 'posts_per_page' => 100)) as $ad): ?>
                    <a href="<?=get_the_permalink($ad)?>" class="card mb-3 item-sub-history">
                        <div>
                            <img src="<?=get_field('ad_thumbnail', $ad->ID)['url']?>" class="card-img-top">
                        </div>
                        <div class="card-label">
                            <span class="hashtag"></span>
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
</div>


<script language="javascript">
    var phone = 767;
    var WinWidth = $(window).width();
    if(WinWidth>phone){
        var thumbsSwiper = new Swiper('.cases_thumbs', {
            spaceBetween: 20,
            slidesPerView: 5,
            watchSlidesVisibility: true,//防止不可点击

        })
        var gallerySwiper = new Swiper('.cases_swiper', {
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
            },

            // 如果需要前进后退按钮
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: thumbsSwiper,
            }
        })
    }
    else{
        var thumbsSwiper = new Swiper('.cases_thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            watchSlidesVisibility: true,//防止不可点击

        })
        var gallerySwiper = new Swiper('.cases_swiper', {
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
            },

            // 如果需要前进后退按钮
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: thumbsSwiper,
            }
        })
    }



</script>


<?php get_footer();?>



