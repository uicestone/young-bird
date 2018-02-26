    <!-- Banner -->
    <!-- for desktop -->
    <div class="container-fluid px-0 d-none d-lg-block">
      <img src="<?=get_field('banner_desktop')['url']?>" width="100%" alt="">
    </div>
    <!-- for pad -->
    <div class="container-fluid px-0 d-none d-md-block d-lg-none">
      <img src="<?=get_field('banner_pad')['url']?>" width="100%" alt="">
    </div>
    <!-- for smart phone -->
    <div class="container-fluid px-0 d-md-none">
      <img src="<?=get_field('banner_phone')['url']?>" width="100%" alt="">
    </div>
    <!-- Body -->
    <div class="container mt-32 mt-md-7 pb-48 pb-md-7 sign-up page-participate">
      <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-start align-items-center logo">
          <img src="<?=get_field('logo')['url']?>" alt="">
        </div>
        <div class="col-md-12 offset-md-2">
          <div class="msg text-center mb-4">
            <img src="<?=get_stylesheet_directory_uri()?>/images/icon-check.png" alt="">
            <h3 class="color-silver font-weight-normal mt-3"><?=__('恭喜参赛成功！', 'young-bird')?></h3>
            <a href="#" class="d-sm-block d-lg-none"><?=__('请至PC端上传您的作品', 'young-bird')?></a>
          </div>
          <a href="<?=get_permalink($group->ID)?>" class="btn btn-lg btn-secondary btn-block mt-5 mt-md-6"><?=$im_leader ? __('上传作品', 'young-bird') : __('查看团队', 'young-bird')?></a>
        </div>
      </div>
    </div>
