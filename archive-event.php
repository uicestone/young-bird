<?php get_header();
    if (isset($_GET['history'])):
      get_template_part('archive-event-history');
    elseif (isset($_GET['user-center'])):
      get_template_part('archive-event-user-center');
    else: ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-competition.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_竞赛 <br>COMPETITION</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-4">
      <div class="row mb-2">
        <div class="col-md-18">
          <form action="" class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label for="inputPassword6" class="col-sm-5 col-form-label"><strong>竞赛状态</strong></label>
                <div class="col-sm-19">
                  <select name="status" class="form-control" id="exampleFormControlSelect1" onchange="this.form.submit()">
                    <option value=""<?=!$_GET['status'] ? ' selected' : ''?>>全部状态</option>
                    <option value="started"<?=$_GET['status']=='started' ? ' selected' : ''?>>进行中</option>
                    <option value="starting"<?=$_GET['status']=='starting' ? ' selected' : ''?>>即将开始</option>
                    <option value="ending"<?=$_GET['status']=='ending' ? ' selected' : ''?>>即将结束</option>
                    <option value="ended"<?=$_GET['status']=='ended' ? ' selected' : ''?>>已经结束</option>
                    <option value="judged"<?=$_GET['status']=='judged' ? ' selected' : ''?>>评审完成</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group row">
                <label for="inputPassword6" class="col-sm-5 col-form-label"><strong>竞赛类别</strong></label>
                <div class="col-sm-19">
                  <select name="tag" class="form-control" id="exampleFormControlSelect1" onchange="this.form.submit()">
                    <option value=""<?=!$_GET['tag'] ? ' selected' : ''?>>全部类别</option>
                    <?php foreach (get_tags() as $tag): ?>
                    <option value="<?=$tag->slug?>"<?=$_GET['tag']==$tag->slug ? ' selected' : ''?>><?=$tag->name?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- <div class="col-md-6"></div> -->
      </div>
      <div class="row">
        <div class="col-md-18">
          <div class="row">
            <?php while (have_posts()): the_post(); ?>
            <div class="col-md-12">
              <div class="card mb-4 item-history">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('vga', array ('class' => 'card-img-top')); ?>
                  <div class="card-body mt-4">
                    <div class="row head justify-content-between align-items-center">
                      <div class="labels">
                        <?php if ($event_category = get_the_terms(get_the_ID(), 'event_category')): foreach ($event_category as $term): ?>
                        <b class="label color-grey" style="color: <?=get_field('color', $term)?>"><?=$term->name?></b>
                        <?php endforeach; endif; ?>
                      </div>
                      <div><?=get_post_meta(get_the_ID(), 'start_date', true)?> ~ <?=get_post_meta(get_the_ID(), 'end_date', true)?></div>
                    </div>
                    <h3 class="mt-3"><?php the_title(); ?></h3>
                    <p class="color-black mb-4 organizer"><?=get_post_meta(get_the_ID(), 'organizer', true)?></p>
                    <p><?php the_excerpt(); ?></p>
                    <div class="action row align-items-center">
                      <i class="far fa-user mr-2"></i>
                      <b class="mr-4">参赛人数 / <?=get_post_meta(get_the_ID(), 'attendees', true) ?: 0?></b>
                      <i class="far fa-heart"></i>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <?php endwhile; ?>
          </div>
          <!--<button type="button" class="btn btn-outline-primary mx-auto d-block btn-common mb-4">发现更多</button>-->
        </div>
        <div class="col-md-6">
          <?php foreach (get_posts(array ('category_name' => 'event-list-ad')) as $ad): ?>
          <a href="#" class="card mb-3 item-sub-history">
            <?=get_the_post_thumbnail($ad->ID, '8-7', array ('class' => 'card-img-top'))?>
            <div class="card-body">
              <h4><?=get_the_title($ad->ID)?><br><?=get_the_subtitle($ad->ID)?></h4>
              <p><?=get_the_excerpt($ad->ID)?></p>
              <?php if ($ad_event = get_field('event', $ad)): ?>
              <p>截止日期：<?=get_post_meta($ad_event->ID, 'end_date', true)?></p>
              <?php endif; ?>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
<?php endif;
get_footer();
