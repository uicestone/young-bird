<?php
if ( ! function_exists( 'wp_handle_upload' ) ) {
  require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

if ($_FILES['poster'] && $_FILES['images']) {
  update_post_meta(get_the_ID(), 'award', $_POST['award']);
  update_post_meta(get_the_ID(), 'desc', $_POST['desc']);

  $poster = wp_handle_upload($_FILES['poster'], array ('test_form' => false));
  update_post_meta(get_the_ID(), 'poster', $poster['url']);
  $files = $_FILES['images'];
  foreach ($files['name'] as $key => $value) {
    if ($files['name'][$key]) {
      $file = array(
        'name'     => $files['name'][$key],
        'type'     => $files['type'][$key],
        'tmp_name' => $files['tmp_name'][$key],
        'error'    => $files['error'][$key],
        'size'     => $files['size'][$key]
      );

      $upload_image = wp_handle_upload($file, array ('test_form' => false));

      add_post_meta(get_the_ID(), 'images', $upload_image['url']);
    }
  }
}

if ($delete_image_url = $_GET['delete_image']) {
  delete_post_meta(get_the_ID(), 'images', $delete_image_url);
}

get_header(); ?>
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
    <div class="container mt-5 pb-6 work-detail">
      <!-- 简介 -->
      <div class="row mx-auto justify-content-between align-items-end">
        <h1>请上传作品简介</h1>
        <h2 class="color-black">参赛编号：YB<?=strtoupper($post->post_name)?></h2>
      </div>
      <form method="post" enctype="multipart/form-data">
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
              <?php if ($poster = get_post_meta(get_the_ID(), 'poster', true)): ?>
                <img src="<?=$poster?>" style="width:100%;height:100%;object-fit:cover">
              <?php else: ?>
              <i class="fas fa-plus mb-3"></i>
              <p class="mb-1">点击上传封面</p>
              <p class="mb-0">图片最大不超过500KB</p>
              <?php endif; ?>
              <input type="file" name="poster" class="custom-file-input">
            </div>
          </div>
        </div>
        <!-- 作品 -->
        <div class="row mx-auto mt-4">
          <h1>上传作品</h1>
        </div>
        <p>您可以上传最多五张图片，支持的文件类型为：JPG/PNG，图片最大不超过20M。</p>
        <div class="row work-upload mb-3">
          <?php $images = get_post_meta(get_the_ID(), 'images'); foreach ($images as $index => $image): ?>
          <div class="col-lg-2-4">
            <div class="upload-container custom-file-container d-flex justify-content-center align-items-center flex-column">
              <i class="fas fa-plus"></i>
              <p class="mt-2">点击上传图片</p>
              <input type="file" name="images[<?=$index?>]" class="custom-file-input">
              <img src="<?=$image?>">
              <a href="<?php the_permalink(); ?>?delete_image=<?=urlencode($image)?>"><i class="fas fa-trash-alt"></i></a>
            </div>
          </div>
          <?php endforeach; ?>
          <?php for ($i=0; $i<5-count($images); $i++): ?>
          <div class="col-lg-2-4">
            <div class="upload-container custom-file-container d-flex justify-content-center align-items-center flex-column">
              <i class="fas fa-plus"></i>
              <p class="mt-2">点击上传图片</p>
              <input type="file" name="images[]" class="custom-file-input">
              <img src="" class="d-none" alt="">
              <a href="#" class="delete d-none"><i class="fas fa-trash-alt"></i></a>
            </div>
          </div>
          <?php endfor; ?>
        </div>
        <p class="mb-5">拖动图片来改变顺序。</p>
        <div class="row">
          <div class="col-12">
            <button type="button" class="btn btn-secondary btn-block btn-lg btn-preview">预览</button>
            <div class="d-none" data-judge-name="是大雨" data-judge-avatar="<?=get_stylesheet_directory_uri()?>/images/sample/judge.jpg" data-comment="这个作品真心不错">
              <a class="w-100">
                <div class="row mx-auto justify-content-between">
                  <h3>城市里的行走</h3>
                  <h4>YB<?=strtoupper($post->post_name)?></h4>
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
          <div class="col-12">
            <button type="submit" class="btn btn-secondary btn-block btn-lg bg-body-grey">上传</button>
          </div>
        </div>
      </form>
    </div>
<?php get_footer(); ?>
