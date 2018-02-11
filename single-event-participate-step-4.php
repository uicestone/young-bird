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
    <div class="container mt-7 pb-7 sign-up">
      <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-start align-items-center logo">
          <img src="<?=get_field('logo')['url']?>" alt="">
        </div>
        <div class="col-md-12 offset-md-2">
          <div class="msg text-center mb-4">
            <img src="<?=get_stylesheet_directory_uri()?>/images/icon-check.png" alt="">
            <h3 class="mt-3">恭喜参赛成功!</h3>
            <a href="#" class="d-sm-block d-lg-none">请至PC端上传您的作品</a>
          </div>
          <a href="<?=get_permalink($group->ID)?>" class="btn btn-lg btn-secondary btn-block mt-6"><?=$im_leader ? '上传作品' : '查看团队'?></a>
        </div>
      </div>
    </div>