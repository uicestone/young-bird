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
    <div class="container mt-7 pb-4">
      <!-- Filter -->
      <div class="category-container d-flex flex-wrap mb-4">
        <a href="#" class="active">全部</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
        <a href="#">平面设计</a>
      </div>
      <div class="row">
        <div class="col-md-18">
          <div class="row">
            <?php while (have_posts()): the_post(); ?>
            <div class="col-md-12">
              <div class="card mb-4 item-history item-history-no-action">
                  <a href="<?php the_permalink(); ?>"><img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-history.jpg" alt="Card image cap"></a>
                <div class="card-body mt-4">
                  <div class="row head justify-content-between align-items-center">
                    <span class="color-cyan">#建筑设计</span>
                    <div class="tag tag-blue">工作</div>
                  </div>
                  <h3 class="mt-3">2017 良辰美景<br>遮阳伞面设计竞赛</h3>
                  <p>户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。</p>
                  <div class="action"></div>
                </div>
              </div>
            </div>
            <?php endwhile; ?>
          </div>
          <button type="button" class="btn btn-outline-secondary mx-auto d-block btn-common mb-4">发现更多</button>
        </div>
        <div class="col-md-6">
          <a href="#" class="card mb-3 item-sub-history">
            <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-history.jpg" alt="Card image cap">
            <div class="card-label">
              <span>#建筑设计</span>
              <div class="tag tag-blue">工作</div>
            </div>
            <hr />
            <div class="card-body">
              <h4>2015 IN-BETWEEN<br>深圳蛇口太子湾公共文化建筑设计竞赛</h4>
              <p>
                截止日期：2017年11月17日15：00
              </p>
            </div>
          </a>
          <a href="#" class="card mb-3 item-sub-history">
            <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-history.jpg" alt="Card image cap">
            <div class="card-label">
              <span>#建筑设计</span>
              <div class="tag tag-blue">工作</div>
            </div>
            <hr />
            <div class="card-body">
              <h4>2015 IN-BETWEEN<br>深圳蛇口太子湾公共文化建筑设计竞赛</h4>
              <p>
                截止日期：2017年11月17日15：00
              </p>
            </div>
          </a>
        </div>
      </div>
    </div>
<?php get_footer(); elseif (in_array($wp_query->query['category_name'], array ('home-primary', 'home-secondary'))): while (have_posts()): the_post(); ?>
<a href="<?php the_permalink()?>" class="card link">
  <?php the_post_thumbnail($_GET['partial'] === 'primary' ? '5-4' : 'vga' , array('class' => 'card-img-top'))?>
  <div class="card-body">
    <div class="title text-truncate">
      <?php the_title()?>
      <br>
      <?php the_subtitle()?>
    </div>
    <div class="label text-truncate">#城市规划设计、建筑、观设计</div>
    <p class="text-truncate">
      <?php the_excerpt()?>
    </p>
    <?php if ($tags = get_the_tags()): foreach ($tags as $tag): ?>
    <i class="tag tag-orange"><?=$tag->name?></i>
    <?php endforeach; endif; ?>
  </div>
</a>
<?php endwhile; else: ?>
<?php endif; ?>
