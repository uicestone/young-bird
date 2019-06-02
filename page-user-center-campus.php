    <!-- Banner -->


    <div      class="container-fluid sub-banner p-0" style="background: url(https://www.youngbirdplan.com.cn/wp-content/themes/young-bird/images/banner-help-center.jpg) center center / cover no-repeat"
    >
        <div class="container">
            <h1>_个人中心 <br />USER CENTER</h1>
        </div>
    </div>


        <div class="container-fluid user-center-menu">
            <div class="container">
                <ul>
                    <?php if (current_user_can('judge_works')): ?>
                        <li ><a href="<?=pll_home_url()?>judge-center/"><?=__('个人信息', 'young-bird')?></a></li>
                    <?php else: ?>
                        <li><a href="<?=pll_home_url()?>user-center/"><?=__('个人信息', 'young-bird')?></a></li>
                    <?php endif; ?>
                    <li><a href="<?=pll_home_url()?>user-center/?event"><?=__('我的竞赛', 'young-bird')?></a></li>
                    <li><a href="<?=pll_home_url()?>user-center/?activity"><?=__('我的活动', 'young-bird')?></a></li>
                    <li><a href="<?=pll_home_url()?>user-center/?like"><?=__('我的收藏', 'young-bird')?></a></li>
                    <li>
                        <a href="<?=pll_home_url()?>message/"><?=__('消息', 'young-bird')?>
                            <?php if ($has_unread_message = get_user_meta(get_current_user_id(), 'has_unread_message', true)): ?><i></i><?php endif; ?>
                        </a>
                    </li>
                    <?php $user_applyed=get_posts(array(
                        'post_type'=>'campus_apply',
                        'author'=>$user->ID,
                        'meta_key'=>'status',
                        'meta_value'=>'pass',
                    ));

                    if($user_applyed):?>
                        <li  class="active"><a href="<?=pll_home_url()?>user-center/?campus"><?=__('站长中心', 'young-bird')?></a></li>
                    <?php endif;?>

                </ul>
            </div>
        </div>

    <div class="container mt-32 mt-lg-7">
        <div class="zz-title d-flex justify-content-center">
            <h2 class=""><?=__('负责的竞赛', 'young-bird')?></h2>
        </div>
    </div>
    <div class="container mt-32 mt-lg-7 pb-7">
        <div class="row pubu">
            <div class="col-md-24">
                <div class="row pubu-list">

                    <?php foreach($user_applyed as $v):?>

                    <?php
                    $id_dl=get_post_meta($v->ID,'campus_id',true);
                    $campus=get_post($id_dl);
                    if(ICL_LANGUAGE_CODE=='en') {

                        $id_dl=pll_get_post($v->ID, 'en');
                    }

                    $event=get_post_meta($id_dl,'event',true);

                    $event=get_post($event);

                    ?>


                    <div class="col-xl-8 col-md-12">
                        <div class="card mb-4 item-history item-zz">
                            <a
                                 href="<?php print get_permalink($id_dl); ?>"
                            >
                                <?php         print get_the_post_thumbnail($event,'vga', array ('class' => 'card-img-top'));
                                ?>
                                <div class="card-body mt-4">
                                    <div
                                            class="row head justify-content-between align-items-center">
                                        <div class="labels">
                                            <?php if ($event_category = get_the_terms($event->ID, 'event_category')): foreach ($event_category as $term): ?>
                                                <b class="label color-grey" style="color: <?=get_field('color', $term)?>"><?=$term->name?></b>
                                            <?php endforeach; endif; ?>
                                        </div>
                                        <div><?=get_post_meta($event->ID, 'start_date', true)?> ~ <?=get_post_meta($event->ID, 'end_date', true)?></div>
                                    </div>
                                    <h3 class="mt-3"><?php print $event->post_title;?></h3>
                                    <p class="color-black mb-4 organizer">
                                        <?php print get_post_meta($event->ID,'organizer',true);?>
                                    </p>
                                    <p class="color-silver">
                                        <?=$event->post_excerpt;?>
                                    </p>
                                    <div class="action row align-items-center justify-content-between zz_deadline">
                                        <h5><?=__('任务截止日期', 'young-bird')?> / <span><?=date('Y-m-d',get_post_meta($id_dl,'deadline',true));?></span></h5>
                                        <?php $date1=date_create(date('Y-m-d',get_post_meta($id_dl,'deadline',true)));
                                        $date2=date_create(date('Y-m-d'));
                                        $diff=date_diff($date2,$date1);
                                        $days=$diff->days;
                                        $dead = $diff->format('%R%a');
                                       ?>
                                        <?php if($dead>0):?>
                                        <h5 class="count_down"><?=__('倒计', 'young-bird')?><span><?=$days;?></span><?=__('天', 'young-bird')?></h5>
                                        <?php else:?>
                                        <h5 class="count_down"><?=__('超出', 'young-bird')?><span style="color:red!important;"><?=$days;?></span><?=__('天', 'young-bird')?></h5>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        

                </div>
            </div>
        </div>
    </div>

