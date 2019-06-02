<?php
header('Total-Pages: ' . $wp_query->max_num_pages);

get_header();
$user = wp_get_current_user();
$disable=array();
  ?>

<div class="container-fluid">
    <div class="container mt-4 p-xs-0 zz_banner">
        <h2>WELCOME！欢迎加入<br/>Young Bird Plan<br/>校园站长</h2>
        <img class="img-fluid border-0 d-none d-sm-block" src="/img/zz_KV.jpg" />
        <img class="img-fluid border-0 d-block d-sm-none" src="/img/zz_KV_mob.jpg" />
    </div>
</div>
<div class="container mt-32 mt-lg-5">
    <div class="zz-title d-flex justify-content-center">
        <h2 class=""><?=__('目前正在招募站长的竞赛', 'young-bird')?></h2>
    </div>
</div>
<div class="container mt-32 campus_inner">
    <div class="row pubu">
        <div class="col-md-24">
            <div class="row pubu-list">
                <?php $kaiqi=get_posts(array(
                        'post_type'=>'campus',
                        'meta_key'=>'enable',
                        'meta_value'=>true,
                ))?>
          <?php foreach($kaiqi as $k=>$v):?>
            <?php
                $id_dl=pll_get_post($v->ID);
              if(ICL_LANGUAGE_CODE=='en')
              $even = get_post(pll_get_post($id_dl, 'en'));
              if(get_post_meta($v->ID,'enable',true)!=1)
              {
              $disable[]=$v->ID;
              }
              $event=get_post_meta($v->ID,'event',true);

              $event=get_post($event);

              ?>
              <?php
              $user_applyed=get_posts(array(
                  'post_type'=>'campus_apply',
                  'author'=>$user->ID,
                  'meta_key'=>'campus_id',
                  'meta_value'=>$id_dl,
              ));
              if($user->ID==0)
                  $user_applyed=array();

              ?>



              <div class="col-xl-8 col-md-12">
                  <div class="card mb-4 item-history">
                      <a <?php  if(empty($user_applyed)||current_user_can( 'manage_options' )):?> href="<?php the_permalink(); ?>"<?php endif;?>>
                          <?php         print get_the_post_thumbnail($event,'vga', array ('class' => 'card-img-top'));
                          ?>
                          <div class="card-body">
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
                              <div class="action row align-items-center">
                                  <?php  if(empty($user_applyed)):?>
                                      <a  href="<?php the_permalink(); ?>" class="become_zz"><?=__('我要成为站长', 'young-bird')?></a>
                                  <?php else:?>
                                      <a   class="become_zz has_zz"><?=__('已申请', 'young-bird')?></a>
                                  <?php endif;?>
                              </div>
                          </div>
                      </a>
                  </div>
              </div>



          <?php endforeach;?>

            </div>
        </div>
    </div>

</div>
<!--<button
    type="button"
    class="btn btn-outline-primary mx-auto mt-lg-7 d-block btn-common mb-4 btn-loadmore "
    data-base-url=""
>
    发现更多
</button>-->

<div class="container mt-32 campus_inner">
    <div class="zz-title d-flex justify-content-center">
        <h2 class=""><?=__('站长招募已结束的竞赛', 'young-bird')?></h2>
    </div>
</div>
<div class="container mt-32 mt-lg-7">
    <div class="row pubu">
        <div class="col-md-24">
            <div class="row pubu-list">
                <?php while (have_posts()): the_post(); $id_dl = pll_get_post(get_the_ID(), pll_default_language()); ?>

                    <?php

                if(get_post_meta($id_dl,'enable',true)==true)
                        continue;
                    if(ICL_LANGUAGE_CODE=='en')
                        $even = get_post(pll_get_post($id_dl, 'en'));
                    if(get_post_meta(get_the_ID(),'enable',true)!=1)
                    {
                        $disable[]=get_the_ID();
                    }
                    $event=get_post_meta(get_the_ID(),'event',true);

                    $event=get_post($event);

                    ?>
                    <?php
                    $user_applyed=get_posts(array(
                        'post_type'=>'campus_apply',
                        'author'=>$user->ID,
                        'meta_key'=>'campus_id',
                        'meta_value'=>$id_dl,
                    ));
                    if($user->ID==0)
                        $user_applyed=array();

                    ?>



                    <div class="col-xl-8 col-md-12">
                        <div class="card mb-4 item-history">
                            <a <?php  if(empty($user_applyed)||current_user_can( 'manage_options' )):?> href="#"<?php endif;?>>
                                <?php         print get_the_post_thumbnail($event,'vga', array ('class' => 'card-img-top'));
                                ?>
                                <div class="card-body">
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
                                    <div class="action row align-items-center">
                                        <?php  if(empty($user_applyed)):?>
                                            <a  href="#" class="become_zz"><?=__('我要成为站长', 'young-bird')?></a>
                                        <?php else:?>
                                            <a   class="become_zz has_zz"><?=__('已申请', 'young-bird')?></a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>




                <?php endwhile; ?>
            </div>
        <!--    <button
                type="button"
                class="btn btn-outline-primary mx-auto mt-lg-7 d-block btn-common mb-7 btn-loadmore "
                data-base-url=""
            >
                发现更多
            </button>-->
        </div>
    </div>
</div>
<?php get_footer();?>

