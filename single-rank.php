<?php
    get_header();
    if (isset($_GET['more'])):
      get_template_part('single-rank-more');
    else: ?>
    <!-- Banner -->
    <!-- for desktop -->
    <div class="container-fluid px-0 d-none d-lg-block">
      <img src="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-lg.jpg" width="100%" alt="">
    </div>
    <!-- for pad -->
    <div class="container-fluid px-0 d-none d-md-block d-lg-none">
      <img src="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-md.jpg" width="100%" alt="">
    </div>
    <!-- for smart phone -->
    <div class="container-fluid px-0 d-md-none">
      <img src="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-sm.jpg" width="100%" alt="">
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-6 toplist-container">
      <h1 class="text-center color-dark-yellow">TOP3</h1>
      <div>
        <div class="row mt-5 item-work item-top3-container">
          <div class="col-sm-12 mb-4 mb-md-0">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-work.jpg" width="100%" alt="">
          </div>
          <div class="col-sm-12 order-sm-first card item-top3">
            <div class="card-body pb-5">
              <div class="row head justify-content-between align-items-center">
                <div class="label color-dark-yellow font-weight-bold">CHAMPION</div>
                <div class="color-black">YB20114</div>
              </div>
              <h3 class="mt-3">城市里的行走</h3>
              <p>户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。</p>
              <div class="action row align-items-center">
                <i class="fas fa-eye mr-2"></i>
                <span class="mr-4">921</span>
                <i class="far fa-heart mr-2"></i>
                <span class="mr-4">21</span>
              </div>
            </div>
          </div>
        </div>
        <div class="d-none" data-judge-name="是大雨" data-judge-avatar="<?=get_stylesheet_directory_uri()?>/images/sample/judge.jpg" data-comment="这个作品真心不错">
          <a class="w-100">
            <div class="row mx-auto justify-content-between">
              <h3>城市里的行走</h3>
              <h4>YB11110</h4>
            </div>
            <p class="mt-3">户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。
              户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。</p>
          </a>
          <a href="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-lg.jpg">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-sm.jpg" alt="" />
          </a>
          <a href="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-lg.jpg">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-sm.jpg" alt="" />
          </a>
        </div>
      </div>
    </div>
<?php endif;
get_footer();
