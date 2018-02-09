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
                  <select class="form-control" id="exampleFormControlSelect1">
                    <option>进行中</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group row">
                <label for="inputPassword6" class="col-sm-5 col-form-label"><strong>竞赛类别</strong></label>
                <div class="col-sm-19">
                  <select class="form-control" id="exampleFormControlSelect1">
                    <option>建筑设计</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
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
                  <a href="<?php the_permalink(); ?>"><img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-history.jpg" alt="Card image cap"></a>
                <div class="card-body mt-4">
                  <div class="row head justify-content-between align-items-center">
                    <div class="label color-rose">Pattern design</div>
                    <div>2017/01/01-2017/6/20</div>
                  </div>
                  <h3 class="mt-3">2017 良辰美景<br>遮阳伞面设计竞赛</h3>
                  <p class="color-black mb-4">竞赛品牌协作方／sunbrella赛百伦</p>
                  <p>户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。</p>
                  <div class="action row align-items-center">
                    <i class="far fa-user mr-2"></i>
                    <span class="mr-4">参赛人数 / 921</span>
                    <i class="far fa-heart"></i>
                  </div>
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
            <div class="card-body">
              <h4>2015 IN-BETWEEN<br>深圳蛇口太子湾公共文化建筑设计竞赛</h4>
              <p>
                截止日期：2017年11月17日15：00
              </p>
            </div>
          </a>
          <a href="#" class="card mb-3 item-sub-history">
            <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-history.jpg" alt="Card image cap">
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
<?php endif;
get_footer();
