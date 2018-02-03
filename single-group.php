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
    <div class="mt-7 pb-7 page-group-detail">
      <div class="container members mb-5">
        <div class="row justify-content-between header mb-3">
          <h3>AFLSH（成员/4）</h3>
          <h3>参赛编号：YB201222</h3>
        </div>
        <div class="member-list">
          <div class="captain avatar-container d-flex align-items-center">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/judge.jpg" class="rounded-circle" alt="">
            <div class="ml-4">
              <div class="role">/组长</div>
              <div class="name">张小娴</div>
            </div>
          </div>
          <div class="d-flex flex-wrap">
            <div class="avatar-container d-flex align-items-center">
              <img src="<?=get_stylesheet_directory_uri()?>/images/sample/judge.jpg" class="rounded-circle" alt="">
              <div class="ml-4">
                <div class="role">/组员</div>
                <div class="name">张小娴</div>
              </div>
              <a href="#">
                <i class="fas fa-times"></i>
              </a>
            </div>
            <div class="avatar-container d-flex align-items-center">
              <img src="<?=get_stylesheet_directory_uri()?>/images/sample/judge.jpg" class="rounded-circle" alt="">
              <div class="ml-4">
                <div class="role">/组员</div>
                <div class="name">张小娴</div>
              </div>
              <a href="#">
                <i class="fas fa-times"></i>
              </a>
            </div>
            <div class="avatar-container d-flex flex-column align-items-center">
              <div class="d-flex align-items-center">
                <img src="<?=get_stylesheet_directory_uri()?>/images/sample/judge.jpg" class="rounded-circle" alt="">
                <strong class="name ml-4">张小娴</strong>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="button" class="btn btn-outline-secondary btn-block">同意</button>
                </div>
                <div class="col-12">
                  <button type="button" class="btn btn-outline-secondary btn-block">忽略</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container works">
        <div class="row header">
          <h3>作品</h3>
        </div>
        <div class="work-list">
          <!-- 未上传 -->
          <div class="no-work">
            <div class="row">
              <div class="col">
                <h3 class="color-black mt-4 mb-3">请上传您的作品</h3>
              </div>
            </div>
            <div class="row justify-content-end">
              <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-outline-secondary btn-common">上传</button>
              </div>
            </div>
          </div>
          <!-- 已上传 -->
          <div class="row mt-6 work-container">
            <div class="col-sm-12 mb-4 mb-md-0">
              <img src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-work.jpg" width="100%" alt="">
            </div>
            <div class="col-sm-12 order-sm-first card item-top3">
              <div class="card-body pb-5">
                <h3>城市里的行走</h3>
                <p>户外遮阳伞在城市公共场所中的使用随处可见。它不仅成为人们抵抗紫外线的一道屏障，也装点着城市的户外环境。然而国内市场上的户外遮阳伞普遍存在着褪色，发霉，肮脏和破损等现象。</p>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col d-flex justify-content-end">
              <button type="button" class="btn btn-outline-secondary btn-common">修改</button>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php get_footer(); ?>
