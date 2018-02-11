<?php
the_post();

$user = wp_get_current_user();

$participate_fields = ['name', 'identity', 'id_card', 'birthday', 'school', 'major', 'country', 'city', 'company', 'department', 'title'];
foreach ($participate_fields as $field) {
  $$field =  get_user_meta($user->ID, $field, true);
}

if (isset($_POST['participate'])) {
  foreach ($participate_fields as $field) {
    if (isset($_POST[$field])) {
      update_user_meta($user->ID, $field, $_POST[$field]);
    }
  }
  header('Location: ' . get_the_permalink() . '?participate=' . $_POST['participate']); exit;
}

get_header();

if (isset($_GET['participate'])):
  $step = $_GET['participate'] ?: 'step-1';
  include(locate_template('single-event-participate-' . $step . '.php'));
else:
?>
    <!-- Body -->
    <div class="container page-event-detail pb-4">
      <div class="sidebar">
        <ul>
          <li>
            <a href="#section1">竞赛命题</a>
          </li>
          <li>
            <a href="#section2">奖项设置</a>
          </li>
          <li>
            <a href="#section3">评委介绍</a>
          </li>
          <li>
            <a href="#section4">Q&A</a>
          </li>
          <li>
            <a href="#section5">相关新闻</a>
          </li>
          <li>
            <a href="#">下载文件</a>
          </li>
          <li class="active">
            <a href="<?php the_permalink(); ?>?participate">参赛</a>
          </li>
        </ul>
      </div>
      <div class="content">
        <section class="header">
          <!-- poster -->
          <div class="poster">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/event-detail-poster.jpg" alt="">
          </div>
          <!-- title -->
          <div class="title row justify-content-between align-items-center mx-auto">
            <h1 class="color-black font-weight-bold"><?php the_title(); ?></h1>
            <div class="action">
              <i class="far fa-user mr-2"></i>
              <span class="mr-4">参赛人数 / 912</span>
              <i class="far fa-heart"></i>
            </div>
          </div>
          <span>2017/12/22~2018/8/8</span>
          <div class="row mx-auto justify-content-between align-items-center mt-3">
            <i class="tag tag-rose">PATTERN DESIGN</i>
            <div>
              分享至：
            </div>
          </div>
        </section>
        <div class="context">
          <h2 class="row align-items-center mx-auto" id="section1">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt="">
            <span>竞赛命题</span>
          </h2>
          <div class="editor">
            <h3>/设计要求</h3>
            <p>户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。其核心原因是使用了较为低劣的非功能性面料，不仅会因其不抗紫外线而损害使用者的健康，还会因其既不耐用也不环保的材料对环境造成伤害，由于质量较差带来的频繁的更换也对城市造成了一定的负担。</p>
          </div>
          <h2 class="row align-items-center mx-auto" id="section2">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt="">
            <span>奖项设置</span>
          </h2>
          <div class="editor">
            <p>户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。其核心原因是使用了较为低劣的非功能性面料，不仅会因其不抗紫外线而损害使用者的健康，还会因其既不耐用也不环保的材料对环境造成伤害，由于质量较差带来的频繁的更换也对城市造成了一定的负担。</p>
          </div>
          <h2 class="row align-items-center mx-auto" id="section3">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt="">
            <span>评委介绍</span>
          </h2>
          <div class="editor judge-list row">
            <div class="col-md-8">
              <a href="#">
                <div class="d-flex align-items-center py-4">
                  <div class="avatar">
                    <img src="<?=get_stylesheet_directory_uri()?>/images/sample/judge.jpg" alt="">
                  </div>
                  <div class="desc pl-3">
                    <p class="color-black font-weight-bold">鲁秋石<br>Uice Stone</p>
                    <small class="color-black font-weight-bold">水平线设计品牌</small>
                    <br>
                    <small class="color-black font-weight-bold">创始人&首席创意总监</small>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <h2 class="row align-items-center mx-auto" id="section4">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/icon-shade-scope.png" alt="">
            <span>Q&A</span>
          </h2>
          <div class="editor">
            <h3>/设计要求</h3>
            <p>户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。其核心原因是使用了较为低劣的非功能性面料，不仅会因其不抗紫外线而损害使用者的健康，还会因其既不耐用也不环保的材料对环境造成伤害，由于质量较差带来的频繁的更换也对城市造成了一定的负担。</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid bg-light-grey" id="section5">
      <div class="container">
        <div class="owl-carousel related-news owl-theme">
          <div class="item">
            <a href="#" class="card mb-3 item-sub-history">
              <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/news-poster-slider.png" alt="Card image cap">
              <div class="card-label">
                <span>#建筑设计</span>
                <div class="tag tag-blue">工作</div>
              </div>
              <hr />
              <div class="card-body">
                <h4 class="text-truncate">2015 IN-BETWEEN</h4>
                <h4 class="text-truncate">深圳蛇口太子湾公共文化建筑设计竞赛</h4>
                <p>
                  截止日期：2017年11月17日15：00
                </p>
              </div>
            </a>
          </div>
          <div class="item">
            <a href="#" class="card mb-3 item-sub-history">
              <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/news-poster-slider.png" alt="Card image cap">
              <div class="card-label">
                <span>#建筑设计</span>
                <div class="tag tag-blue">工作</div>
              </div>
              <hr />
              <div class="card-body">
                <h4 class="text-truncate">2015 IN-BETWEEN</h4>
                <h4 class="text-truncate">深圳蛇口太子湾公共文化建筑设计竞赛</h4>
                <p>
                  截止日期：2017年11月17日15：00
                </p>
              </div>
            </a>
          </div>
          <div class="item">
            <a href="#" class="card mb-3 item-sub-history">
              <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/news-poster-slider.png" alt="Card image cap">
              <div class="card-label">
                <span>#建筑设计</span>
                <div class="tag tag-blue">工作</div>
              </div>
              <hr />
              <div class="card-body">
                <h4 class="text-truncate">2015 IN-BETWEEN</h4>
                <h4 class="text-truncate">深圳蛇口太子湾公共文化建筑设计竞赛</h4>
                <p>
                  截止日期：2017年11月17日15：00
                </p>
              </div>
            </a>
          </div>
          <div class="item">
            <a href="#" class="card mb-3 item-sub-history">
              <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/news-poster-slider.png" alt="Card image cap">
              <div class="card-label">
                <span>#建筑设计</span>
                <div class="tag tag-blue">工作</div>
              </div>
              <hr />
              <div class="card-body">
                <h4 class="text-truncate">2015 IN-BETWEEN</h4>
                <h4 class="text-truncate">深圳蛇口太子湾公共文化建筑设计竞赛</h4>
                <p>
                  截止日期：2017年11月17日15：00
                </p>
              </div>
            </a>
          </div>
          <div class="item">
            <a href="#" class="card mb-3 item-sub-history">
              <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/news-poster-slider.png" alt="Card image cap">
              <div class="card-label">
                <span>#建筑设计</span>
                <div class="tag tag-blue">工作</div>
              </div>
              <hr />
              <div class="card-body">
                <h4 class="text-truncate">2015 IN-BETWEEN</h4>
                <h4 class="text-truncate">深圳蛇口太子湾公共文化建筑设计竞赛</h4>
                <p>
                  截止日期：2017年11月17日15：00
                </p>
              </div>
            </a>
          </div>


        </div>
      </div>
    </div>
<?php endif; get_footer(); ?>
