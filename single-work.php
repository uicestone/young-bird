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
    <div class="container mt-5 pb-6">
      <!-- 简介 -->
      <div class="row mx-auto justify-content-between align-items-end">
        <h1>请上传作品简介</h1>
        <h2 class="color-black">参赛编号：YB<?=strtoupper($post->post_name)?></h2>
      </div>
      <div class="row mt-3 word-desc">
        <div class="col-md-12">
          <div class="form-group">
            <div class="input-group input-group-lg">
              <input type="text" class="form-control" placeholder="曾获奖项">
            </div>
          </div>
          <div class="input-group input-group-lg">
            <textarea class="form-control" placeholder="描述"></textarea>
          </div>
        </div>
        <div class="col-md-12">
          <div class="poster custom-file-container d-flex justify-content-center align-items-center flex-column">
            <i class="fas fa-plus mb-3"></i>
            <p class="mb-1">点击上传封面</p>
            <p class="mb-0">图片最大不超过500KB</p>
            <input type="file" class="custom-file-input">
          </div>
        </div>
      </div>
      <!-- 作品 -->
      <div class="row mx-auto mt-4">
        <h1>上传作品</h1>
      </div>
      <p>您可以上传最多五张图片，支持的文件类型为：JPG/PNG，图片最大不超过20M。</p>
      <div class="row work-upload mb-3">
        <div class="col-lg-2-4">
          <div class="upload-container custom-file-container d-flex justify-content-center align-items-center flex-column">
            <i class="fas fa-plus"></i>
            <p class="mt-2">点击上传图片</p>
            <input type="file" class="custom-file-input">
            <img src="<?=get_stylesheet_directory_uri()?>/images/sample/poster-work.jpg" alt="">
            <i class="fas fa-trash-alt"></i>
          </div>
        </div>
        <div class="col-lg-2-4">
          <div class="upload-container custom-file-container d-flex justify-content-center align-items-center flex-column">
            <i class="fas fa-plus"></i>
            <p class="mt-2">点击上传图片</p>
            <input type="file" class="custom-file-input">
          </div>
        </div>
        <div class="col-lg-2-4">
          <div class="upload-container custom-file-container d-flex justify-content-center align-items-center flex-column">
            <i class="fas fa-plus"></i>
            <p class="mt-2">点击上传图片</p>
            <input type="file" class="custom-file-input">
          </div>
        </div>
        <div class="col-lg-2-4">
          <div class="upload-container custom-file-container d-flex justify-content-center align-items-center flex-column">
            <i class="fas fa-plus"></i>
            <p class="mt-2">点击上传图片</p>
            <input type="file" class="custom-file-input">
          </div>
        </div>
        <div class="col-lg-2-4">
          <div class="upload-container custom-file-container d-flex justify-content-center align-items-center flex-column">
            <i class="fas fa-plus"></i>
            <p class="mt-2">点击上传图片</p>
            <input type="file" class="custom-file-input">
          </div>
        </div>
      </div>
      <p class="mb-5">拖动图片来改变顺序。</p>
      <div class="row">
        <div class="col-12">
          <button type="button" class="btn btn-secondary btn-block btn-lg">预览</button>
        </div>
        <div class="col-12">
          <button type="button" class="btn btn-secondary btn-block btn-lg bg-body-grey">上传</button>
        </div>
      </div>
    </div>
<?php get_footer(); ?>
