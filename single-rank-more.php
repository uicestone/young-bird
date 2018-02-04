<?php get_header(); ?>
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
      <h1 class="text-center color-dark-yellow">TOP50</h1>
      <div class="row mt-5">
        <div class="col-sm-12 col-md-8 col-lg-2-4 mb-4">
          <div class="card mb-4 item-history item-top50 item-work">
            <img class="card-img-top" src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-history.jpg" alt="Card image cap">
            <div class="card-body mt-4">
              <div class="row head justify-content-between align-items-center">
                <div class="label color-black font-weight-bold">彻骨分阿斯</div>
                <div>YB20114</div>
              </div>
              <p class="pt-3">户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。</p>
              <div class="action row align-items-center">
                <i class="fas fa-eye mr-1"></i>
                <span class="mr-2">921</span>
                <i class="far fa-heart mr-1"></i>
                <span class="mr-2">921</span>
              </div>
            </div>
          </div>
          <div class="d-none" data-judge-name="是大雨" data-judge-avatar="<?=get_stylesheet_directory_uri()?>/images/sample/judge.jpg" data-comment="这个作品真心不错">
            <!-- 作品简介 -->
            <a class="w-100">
              <div class="row mx-auto justify-content-between">
                <h3>城市里的行走</h3>
                <h4>YB11110</h4>
              </div>
              <p class="mt-3">户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。
                户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。</p>
            </a>
            <!-- 图集 -->
            <a href="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-lg.jpg">
              <img src="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-sm.jpg" alt="" />
            </a>
            <a href="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-lg.jpg">
              <img src="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-sm.jpg" alt="" />
            </a>
          </div>
        </div>
      </div>
      <button type="button" class="btn btn-outline-secondary mx-auto d-block btn-common mb-4">发现更多</button>
    </div>
<?php get_footer(); ?>
