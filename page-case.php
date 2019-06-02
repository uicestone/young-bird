<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2018/12/20
 * Time: 16:42
 */
/*
Template Name: case
*/

if(isset($_POST['brandid'])){
    $views = (get_post_meta($_POST['brandid'], 'views', true) ?: 0) + 1;
    update_post_meta($_POST['brandid'], 'views', $views);
    echo json_encode(1);
    exit();
}

$cases=get_posts(array(
    'post_type'=>'case',
     'posts_per_page' => -1
));

$tax=get_the_terms($cases[0]->ID, 'event_category');

$casestax=array();
$kv=array();
$casess=$cases;
$current_case='';

if(isset($_GET['case-item'])){
    $casess=get_posts(array(
        'post_type'=>'case',
        'posts_per_page' => -1,
        'meta_key'=>'second',
        'meta_value'=>$_GET['case-item']
    ));
}
foreach($cases as $k=>$case)
{



        $tax = get_the_terms($case->ID, 'event_category');

        foreach ($tax as $v) {

            if(get_post_meta($case->ID,'second',true))
            {
                $casestax[$v->term_id][get_post_meta($case->ID,'second',true)] = get_post_meta($case->ID,'second',true);
            }



        }
        if (get_post_meta($case->ID, 'kvincase', true) == true) {
            $kv[] = $case->ID;
        }


    if(isset($_GET['case-term'])) {
        $current_case=get_term($_GET['case-term'])->name;
        $event_category = get_the_terms($case->ID, 'event_category');
        $has = 0;
        foreach ($event_category as $v) {

            if ($v->term_id == $_GET['case-term']) {
                $has = 1;

            }
        }
        if ($has == 0)
            unset($casess[$k]);
    }

}
foreach($_GET as $k=>$v)
{
    if($k=='case-term'){
        $current_case=get_term($_GET['case-term'])->name;
    }
    if($k=='case-item'){
        $current_case=$v;
    }
}
$casesss=$casess;

$casess=array();
foreach($casesss as $v){
    $casess[]=$v;
}
$last='';
$caseterm=0;
$caseitem=0;
$cget=$_GET;
$it=0;
$brandterm=0;
$branditem=0;
/*foreach($cget as $k=>$v){
    if($k=='case-term'){
        $caseterm=$it;
    }
    if($k=='case-item')
        $caseitem=$it;
}
if($caseterm>$caseitem){
    unset($cget['case-item']);
}
else if($caseitem>$caseterm){
    unset($cget['case-term']);
}*/



$brands=get_posts(array(
    'post_type'=>'post',
    'posts_per_page' => -1
));
foreach($brands as $k=>$v)
{


    $tag=get_the_tag_list('', '、', '', $v->ID);
    if(!mb_strpos($tag,'品牌故事')&&!mb_strpos($tag,'Gallery'))
        unset($brands[$k]);
}

/*$brands=get_posts(array(
    'post_type'=>'brand',
    'posts_per_page' => -1
));
*/

$brandstax=array();

$brandarray=array();


$it=0;
$brandterm=0;
$branditem=0;
foreach($cget as $k=>$v){
    if($k=='brand-term'){
        $brandterm=$it;
    }
    if($k=='brand-item')
        $branditem=$it;
    $it++;
}
$current_brand='';
if($brandterm>$branditem){
    unset($cget['brand-item']);
}
else if($branditem>$brandterm){
    unset($cget['brand-term']);
}

foreach($brands as $k=>$brand)
{
    $tax=get_the_terms($brand->ID, 'news_category');

    foreach($tax as $v)
    {

        $brandstax[$v->term_id][$brand->ID]=$brand->post_title;


    }

    if(isset($_GET['brand-term'])) {
        $current_brand=get_term($_GET['brand-term'])->name;
        $event_category = get_the_terms($brand->ID, 'news_category');
        $has = 0;
        foreach ($event_category as $v) {

            if ($v->term_id == $_GET['brand-term']) {
                $has = 1;
            }
        }
        if ($has == 0) {
            unset($brands[$k]);
        }
    }
}

$brandcata=get_terms(array('taxonomy' => 'news_category', 'orderby' => 'ID', 'order' => 'asc'));
foreach($brandcata as $k=>$v){
    if(empty($brandstax[$v->term_id]))
        unset($brandcata[$k]);
}


$brandss=array();
foreach($brands as $v){
    $brandss[]=$v;
}
$get='';
$get_brand='';
$get_case='';
$brand_term='';
$case_term='';
$brand_item='';
$brand_term='';
foreach ($cget as $k=>$v)
{
    $get.='&'.$k.'='.$v;
    if($k!='brand-item'&&$k!='brand-term')
        $get_brand.='&'.$k.'='.$v;

  /*  if($k!='brand-item')
        $brand_term.='&'.$k.'='.$v;

    if($k!='brand-term')
        $brand_item.='&'.$k.'='.$v;*/
    if($k!='case-item')
        $get_case.='&'.$k.'='.$v;

 /*   if($k!='case-item')
        $case_term.='&'.$k.'='.$v;

    if($k!='case-term')
        $case_item.='&'.$k.'='.$v;*/
}


get_header();
?>

<div class="container-fluid bg-lighter-grey p-0">
    <div class="container case-outer-container">
        <div class="row pubu">
            <div class="col-lg-18 col-md-24 case-inner-container cases_index_swiper">
                <div class="swiper-container cases_swiper_list ">
                    <div class="swiper-wrapper">
                        <?php foreach($kv as $v):?>
                        <div class="swiper-slide">
                            <img class="img-fluid" src="<?=wp_get_attachment_image_url(get_post_meta($v,'kv',true),array('880,400'));?>" alt="">
                        </div>
                        <?php endforeach;?>

                    </div>
                    <!-- 如果需要分页器 -->
                    <div class="swiper-pagination"></div>

                    <!-- 如果需要导航按钮 -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>

                <div class="row pubu-list case_list">
                    <div class="case_items">
                        <div class="case_title d-flex justify-content-between align-items-center col-md-24">
                            <h3><?=__('项目案例', 'young-bird')?></h3>
                            <div class="form-group d-flex justify-content-between align-items-center select-box">
                                <div class="select_nav">
                                    <ul class="select_first">
                                        <!-- 第0层 仅显示类别 -->
                                        <li class="select_item">
                                            <a class="dropdown-toggle" href="#" id="first_level" role="button" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <?php if($current_case):?>
                                                    <?php echo $current_case;?>
                                                <?php else:?>
                                                <?=__('类别', 'young-bird')?>
                                                <?php endif;?>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="first_level">

                                                <li class="select_item"><a class="fenlei-item" data-getinfo ="<?php print pll_home_url();?>case?<?php echo $get_case;?>#case_list">

                                                    <?=__('全部分类', 'young-bird')?>
                                                    </a></li>
                                                <?php foreach (get_terms(array('taxonomy' => 'event_category', 'orderby' => 'ID', 'order' => 'asc')) as $term):?>

                                                <?php if(empty($casestax[$term->term_id])):?>
                                                        <li class="select_item"><a  class="fenlei-item"  data-getinfo="<?php print pll_home_url();?>case?<?php echo $get_case.'&case-term='.$term->term_id;?>#case_list"><?=$term->name?></a></li>
                                                <?php else:?>
                                                    <li class="select_item dropdown ">
                                                        <!-- 一级目录标题 -->

                                                        <a class="dropdown-item dropdown-toggle" data-getinfo="<?php print pll_home_url();?>case?<?php echo $get_case.'&case-term='.$term->term_id;?>#case_list" id="<?=$term->term_id?>" role="button"
                                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                           data-stopPropagation><?=$term->name?></a>
                                                        <ul class="dropdown-menu" aria-labelledby="<?=$term->term_id?>">
                                                            <!-- 二级目录 -->
                                                            <?php foreach($casestax[$term->term_id] as $k=>$v):?>
                                                            <li><a class="dropdown-item" data-getinfo="<?php print pll_home_url();?>case?<?php echo $get_case.'&case-item='.$k;?>"><?=$v;?></a></li>
                                                            <?php endforeach;?>
                                                        </ul>
                                                    </li>

                                                  <?php endif;?>
                                                   <!-- <li class="select_item"</li>-->
                                                <?php endforeach; ?>
                                                <!-- 一级目录 -->


                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="case-second d-lg-none d-xl-none col-24 d-flex">
                            <?php if(isset($_GET['case-term'])):?>
<?php if(!empty($casestax[$_GET['case-term']])):?>
                                    <?php foreach($casestax[$_GET['case-term']] as $k=>$v):?>
                                        <div class="case-second-item"><a class="dropdown-item <?php if($_GET['case-item']==$v) echo 'active';?>" data-getinfo="<?php print pll_home_url();?>case?<?php echo $get_case.'&case-item='.$k;?>"><?=$v;?></a></div>
                                    <?php endforeach;?>
                            <?php endif;?>
                            <?php endif;?>
                        </div>
                        <?php $i=0;
                        for($i=0;$i<6;$i++):?>
                        <?php if(empty($casess[$i]))
                                    continue

                                    ;?>
                        <?php $case=$casess[$i];?>

                            <a href="<?php print get_post_permalink($case->ID);?>" class="case-item col-md-8">
                                <?php get_post_meta($case->ID,'image',true);?>
                                <img class="img-fluid" src="<?php print wp_get_attachment_image_url(get_post_meta($case->ID,'image',true),array('280,210'));?>">
                                <h4><?=$case->post_title;?></h4>
                                <div class="case_info">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        <?php if(get_post_meta($case->ID, 'views', true)):?>
                                        <span class="mr-4"><?=get_post_meta(pll_get_post($case->ID, pll_default_language()), 'views', true);?></span>
                                        <?php else:?>
                                         <span class="mr-4">0</span>
                                         <?php endif;?>
                                        <span class="like-box">
                                          <!--  <i class="<?/*=in_array(pll_get_post($case->ID, pll_default_language()), get_user_meta(get_current_user_id(), 'like_posts') ?: array()) ? 'fas ' : 'far'*/?> fa-heart like" data-post-link="<?/*=get_the_permalink(pll_get_post($case->ID, pll_default_language()))*/?>"></i>
                                          <span class="mr-4 likes"><?php /*print (get_post_meta(pll_get_post($case->ID, pll_default_language()),'like',true)?:0);*/?></span>-->
                                        </span>
                                    </div>
                                    <div>
                                        <?php if ($event_category = get_the_terms($case->ID, 'event_category')): foreach ($event_category as $term): ?>
                                            <i class="tag tag-grey" style="background: <?=get_field('color', $term)?>"><?=$term->name?></i>
                                        <?php endforeach; endif; ?>

                                    </div>
                                </div>
                            </a>
                        <?php endfor;?>
                        <?php if(count($casess)>6):?>
                        <div class="collapse case_collapse" id="case_collapse">
                            <?php $i=6;?>
                            <?php for($i=6;$i<count($cases);$i++):?>
                                <?php if(empty($casess[$i]))
                                    continue

                                    ;?>
                                <?php $case=$casess[$i];?>
                                <a href="<?php print get_post_permalink($case->ID);?>" class="case-item col-md-8">
                                    <?php get_post_meta($case->ID,'image',true);?>
                                    <img class="img-fluid" src="<?php print wp_get_attachment_image_url(get_post_meta($case->ID,'image',true),array('280,210'));?>">
                                    <h4><?=$case->post_title;?></h4>
                                    <div class="case_info">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-eye mr-2"></i>
                                            <?php if(get_post_meta($case->ID, 'views', true)):?>
                                                <span class="mr-4"><?=get_post_meta(pll_get_post($case->ID, pll_default_language()), 'views', true);?></span>
                                            <?php else:?>
                                                <span class="mr-4">0</span>
                                            <?php endif;?>
                                            <span class="like-box">
                                           <!-- <i class="<?/*=in_array(pll_get_post($case->ID, pll_default_language()), get_user_meta(get_current_user_id(), 'like_posts') ?: array()) ? 'fas ' : 'far'*/?> fa-heart like" data-post-link="<?/*=get_the_permalink(pll_get_post($case->ID, pll_default_language()))*/?>"></i>
                                          <span class="mr-4 likes"><?php /*print (get_post_meta(pll_get_post($case->ID, pll_default_language()),'like',true)?:0);*/?></span>-->
                                        </span>
                                        </div>
                                        <div>
                                            <?php if ($event_category = get_the_terms($case->ID, 'event_category')): foreach ($event_category as $term): ?>
                                                <i class="tag tag-grey" style="background: <?=get_field('color', $term)?>"><?=$term->name?></i>
                                            <?php endforeach; endif; ?>

                                        </div>
                                    </div>
                                </a>
                            <?php endfor;?>


                        </div>
                        <button class="btn btn-link read_more" type="button" data-toggle="collapse" data-target="#case_collapse"
                                aria-expanded="false" aria-controls="case_collapse">
                                <?=__('更多', 'young-bird')?>
                        </button>

                        <?php endif;?>

                    </div>
                </div>

                <div class="row pubu-list story_list" >
                    <div class="case_items">
                        <div class="case_title d-flex justify-content-between align-items-center col-md-24">
                            <h3><?=__('知识分享', 'young-bird')?></h3>

                            <div class="form-group d-flex justify-content-between align-items-center select-box">
                                <div class="select_nav">
                                    <ul class="select_first">
                                        <!-- 第0层 仅显示类别 -->
                                        <li class="select_item">
                                <!--            --><?php /*$gett=$get;
                                            unset($gett['brand-item']);
                                            unset($gett['brand-term']);*/?>
                                            <a class="dropdown-toggle" href="#" id="first_level" role="button" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">


                                                <?php if($current_brand):?>
                                                    <?php echo $current_brand;?>
                                                <?php else:?>
                                                    <?=__('类别', 'young-bird')?>
                                                <?php endif;?>
                                              </a>
                                            <ul class="dropdown-menu" aria-labelledby="first_level">

                                                <li class="select_item"><a class="fenlei-item" data-getinfo="<?php print pll_home_url();?>case?<?php echo $get_brand;?>#story_list">

                                                    <?=__('全部分类', 'young-bird')?>
                                                    </a></li>
                                                <?php foreach ($brandcata  as $term):?>

                                                    <?php if(true):?>
                                                        <li class="select_item"><a  class="fenlei-item"  data-getinfo="<?php print pll_home_url();?>case?<?php echo $get_brand.'&brand-term='.$term->term_id;?>#story_list" id="<?=$term->term_id?>"><?=$term->name?></a></li>
                                                    <?php else:?>
                                                        <li class="select_item dropdown ">
                                                            <!-- 一级目录标题 -->
                                                            <a class="dropdown-item dropdown-toggle" data-getinfo="<?php print pll_home_url();?>case?<?php echo $get_brand.'&brand-term='.$term->term_id;?>#story_list" id="<?=$term->term_id?>" id="<?=$term->term_id?>" role="button"
                                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                               data-stopPropagation><?=$term->name?></a>
                                                            <ul class="dropdown-menu" aria-labelledby="<?=$term->term_id?>">
                                                                <!-- 二级目录 -->
                                                                <?php foreach($brandstax[$term->term_id] as $k=>$v):?>
                                                                    <li><a class="dropdown-item"  data-getinfo="<?php print pll_home_url();?>case?<?php echo $get_brand.'&brand-item='.$k;?>#story_list"><?=$v;?></a></li>
                                                                <?php endforeach;?>
                                                            </ul>
                                                        </li>

                                                    <?php endif;?>
                                                    <!-- <li class="select_item"</li>-->
                                                <?php endforeach; ?>
                                                <!-- 一级目录 -->


                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <?php $i=0;
                        for($i=0;$i<3;$i++):?>
                            <?php if(!isset($brandss[$i]))
                                continue

                                ;?>
                            <?php $case=$brandss[$i];?>
                            <a  href="<?php print get_the_permalink($case->ID);?>" id="brand-<?php echo $case->ID;?>"class="case-item brand-item col-md-8">
                                <?php get_post_meta($case->ID,'image',true);?>
                                <?php
                                 print get_the_post_thumbnail($case->ID,'vga',array('class'=>'card-img-top')); ?>
                              <!--  <img class="img-fluid" src="<?php /*print wp_get_attachment_image_url(get_post_meta($case->ID,'image',true),array('280,210'));*/?>">-->
                                <h4><?=$case->post_title;?></h4>
                                <div class="case_info">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-eye mr-2"></i>

                                        <?php if(get_post_meta(pll_get_post($case->ID, pll_default_language()), 'views', true)):?>
                                            <span class="mr-4"><?=get_post_meta(pll_get_post($case->ID, pll_default_language()), 'views', true);?></span>
                                        <?php else:?>
                                            <span class="mr-4">0</span>
                                        <?php endif;?>
                                        <span class="like-box">

                                        </span>
                                    </div>
                                    <div>
                                        <?php if ($event_category = get_the_terms($case->ID, 'news_category')): foreach ($event_category as $term): ?>
                                            <i class="tag tag-grey" style="background: <?=get_field('color', $term)?>"><?=$term->name?></i>
                                        <?php endforeach; endif; ?>

                                    </div>
                                </div>
                            </a>
                        <?php endfor;?>
                        <?php if(count($brandss)>3):?>
                            <div class="collapse case_collapse" id="case_collapse2">
                                <?php $i=3;?>
                                <?php for($i=3;$i<count($brandss);$i++):?>
                                    <?php $case=$brandss[$i];?>
                                    <a  href="<?php print get_the_permalink($case->ID);?>" class="case-item brand-item col-md-8">
                                        <?php get_post_meta($case->ID,'image',true);?>
                                        <?php
                                        print get_the_post_thumbnail($case->ID,'vga',array('class'=>'card-img-top')); ?>
                                        <h4><?=$case->post_title;?></h4>
                                        <div class="case_info">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-eye mr-2"></i>
                                                <?php if(get_post_meta(pll_get_post($case->ID, pll_default_language()), 'views', true)):?>
                                                    <span class="mr-4"><?=get_post_meta(pll_get_post($case->ID, pll_default_language()), 'views', true);?></span>
                                                <?php else:?>

                                                    <span class="mr-4">0</span>
                                                <?php endif;?>
                                                <span class="like-box">

                                        </span>
                                            </div>
                                            <div>
                                                <?php if ($event_category = get_the_terms($case->ID, 'news_category')): foreach ($event_category as $term): ?>
                                                    <i class="tag tag-grey" style="background: <?=get_field('color', $term)?>"><?=$term->name?></i>
                                                <?php endforeach; endif; ?>

                                            </div>
                                        </div>
                                    </a>
                                <?php endfor;?>


                            </div>
                            <button class="btn btn-link read_more" type="button" data-toggle="collapse" data-target="#case_collapse2"
                                    aria-expanded="false" aria-controls="case_collapse2">
                                    <?=__('更多', 'young-bird')?>
                            </button>

                        <?php endif;?>

                    </div>
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



<?php  get_footer(); ?>

<script>
    $(function () {


        // $(".select_item.dropdown").click(function(){
        //     $(this).addClass("show");
        //     console.log(1);
        // })
        $("body").on('click','[data-stopPropagation]',function (e) {
            e.stopPropagation();
        });
        $('.select_nav').bootnavbar();
    })


    var gallerySwiper = new Swiper('.cases_swiper_list', {
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
        },

        // 如果需要前进后退按钮
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    })
    $('a.dropdown-item').click(function(){

        window.location.href=$(this).attr('data-getinfo');

    });

    $('a.fenlei-item').click(function(){

        window.location.href=$(this).attr('data-getinfo');

    });


</script>