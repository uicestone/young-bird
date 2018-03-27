<?php
if ( ! function_exists( 'wp_handle_upload' ) ) {
  require_once( ABSPATH . 'wp-admin/includes/file.php' );
}

the_post();

$event_id = get_post_meta(get_the_ID(), 'event', true);
$description = get_post_meta(get_the_ID(), 'description', true);
$images = get_post_meta(get_the_ID(), 'images');
$editable = $post->post_author == get_current_user_id();

if (isset($_POST['submit'])) {
  $work = get_post();
  $work->post_title = $_POST['work_title'];
  wp_update_post($work);
  update_post_meta(get_the_ID(), 'description', $_POST['description']);

  $poster = wp_handle_upload($_FILES['poster'], array ('test_form' => false));

  if($poster['url']) {

    if ( ! function_exists( 'wp_crop_image' ) ) {
      include( ABSPATH . 'wp-admin/includes/image.php' );
    }

    update_post_meta(get_the_ID(), 'poster', $poster['url']);

    $attachment = array(
      'post_title' => $poster['name'],
      'post_type' => 'attachment',
      'post_parent' => get_the_ID(),
      'post_mime_type' => $poster['type'],
      'guid' => $poster['url']
    );

    $thumbnail_id = wp_insert_attachment( $attachment, $poster[ 'file' ], get_the_ID() );
    wp_update_attachment_metadata( $thumbnail_id, wp_generate_attachment_metadata( $thumbnail_id, $poster['file'] ) );
    update_attached_file($thumbnail_id, $poster['file']);
    set_post_thumbnail($work->ID, $thumbnail_id);
  }

  $files = $_FILES['images'];

  foreach ($files['name'] as $index => $filename) {
    if ($files['name'][$index]) {
      $file = array(
        'name'     => $files['name'][$index],
        'type'     => $files['type'][$index],
        'tmp_name' => $files['tmp_name'][$index],
        'error'    => $files['error'][$index],
        'size'     => $files['size'][$index]
      );

      $upload_image = wp_handle_upload($file, array ('test_form' => false));

      if ($images[$index]) {
        update_post_meta(get_the_ID(), 'images', $upload_image['url'], $images[$index]);
      }
      else {
        add_post_meta(get_the_ID(), 'images', $upload_image['url']);
      }
    }
  }

  $group_id = get_post_meta($work->ID, 'group', true);

  if ($group_id) {
    $group = get_post($group_id);
    $captain_id = $group->post_author;
    $member_ids = get_post_meta($group_id, 'members') ?: array();
    foreach ($member_ids as $member_id) {
      if ($member_id == $captain_id) continue;
      send_message($member_id, 'the-team-project-has-been-uploaded');
    }
    header('Location: ' . get_the_permalink($group_id)); exit;
  } else {
    header('Location: ' . get_the_permalink($event_id)); exit;
  }
}

if (isset($_GET['delete_image']) && $delete_image_url = $_GET['delete_image']) {
  delete_post_meta(get_the_ID(), 'images', $delete_image_url);
}

if (isset($_POST['status'])) {
  update_post_meta(get_the_ID(), 'status', $_POST['status']);
  exit;
}

if (isset($_POST['score']) && isset($_POST['comment'])) {

  $score = (int) $_POST['score'];

  $score_previous = get_post_meta(get_the_ID(), 'score' . get_current_user_id(), true);
  $scores = get_post_meta(get_the_ID(), 'scores', true) ?: array();

  update_post_meta(get_the_ID(), 'score_' . get_current_user_id(), $score);
  update_post_meta(get_the_ID(), 'comment_' . get_current_user_id(), $_POST['comment']);

  if ($score_previous) {
    $index = array_search($score_previous, $scores);
    $scores[$index] = $score;
  }
  else {
    $scores[] = $score;
  }

  update_post_meta(get_the_ID(), 'scores', $scores);
  update_post_meta(get_the_ID(), 'score', array_sum($scores) / count($scores));
  exit;
}

if (isset($_POST['like'])) {
  redirect_login();
  $votes = get_post_meta(get_the_ID(), 'votes', true);
  if (json_decode($_POST['like'])) {
    add_user_meta(get_current_user_id(), 'vote_works', get_the_ID());
    update_post_meta(get_the_ID(), 'votes', ++$votes);
  }
  else {
    delete_user_meta(get_current_user_id(), 'vote_works', get_the_ID());
    update_post_meta(get_the_ID(), 'votes', --$votes);
  }

  echo $votes; exit;
}

get_header(); ?>
    <!-- Banner -->
    <!-- for desktop -->
    <div class="container-fluid px-0 d-none d-lg-block">
      <img src="<?=get_field('banner_desktop', $event_id)['url']?>" width="100%" alt="">
    </div>
    <!-- for pad -->
    <div class="container-fluid px-0 d-none d-md-block d-lg-none">
      <img src="<?=get_field('banner_pad', $event_id)['url']?>" width="100%" alt="">
    </div>
    <!-- for smart phone -->
    <div class="container-fluid px-0 d-md-none">
      <img src="<?=get_field('banner_phone', $event_id)['url']?>" width="100%" alt="">
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-6 work-detail">
      <!-- 简介 -->
      <div class="row mx-auto justify-content-between align-items-end">
        <h1 class="font-weight-bold color-silver"><?=$editable ? __('请上传作品简介', 'young-bird') : __('作品简介', 'young-bird')?></h1>
        <h2 class="font-weight-bold color-silver"><?=__('参赛编号：', 'young-bird')?>YB<?=strtoupper($post->post_name)?></h2>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="row mt-3 work-desc">
          <div class="col-md-12">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="work_title" value="<?php the_title(); ?>"<?=$editable? '' : ' disabled'?> class="form-control" placeholder="<?=__('作品名', 'young-bird')?>">
              </div>
            </div>
            <div class="input-group input-group-lg">
              <textarea class="form-control" name="description"<?=$editable? '' : ' disabled'?> placeholder="<?=__('描述', 'young-bird')?>"><?=$description?></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="poster custom-file-container d-flex justify-content-center align-items-center flex-column">
              <input type="file" name="poster"<?=$editable? '' : ' disabled'?> class="custom-file-input">
              <?php if ($poster = get_post_meta(get_the_ID(), 'poster', true)): ?>
                <img src="<?=$poster?>">
              <?php else: ?>
              <img src="" alt="" class="d-none">
              <i class="fas fa-plus mb-3 color-silver"></i>
              <p class="mb-1 color-silver"><?=__('点击上传封面', 'young-bird')?></p>
              <p class="mb-0 color-silver"><?=__('图片最大不超过', 'young-bird')?>500KB</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <!-- 作品 -->
        <div class="row mx-auto mt-4">
          <h1 class="font-weight-bold color-silver"><?=$editable ? __('上传作品', 'young-bird') : __('作品', 'young-bird')?></h1>
        </div>
        <?php if ($editable): ?>
        <p class="font-weight-normal color-silver"><?=__('您可以上传最多五张图片，支持的文件类型为：JPG/PNG，图片最大不超过20M。', 'young-bird')?></p>
        <?php endif; ?>
        <div class="row work-upload mb-3">
          <?php foreach ($images as $index => $image): ?>
          <div class="col-lg-2-4">
            <div class="upload-container custom-file-container d-flex justify-content-center align-items-center flex-column">
              <i class="fas fa-plus color-silver"></i>
              <p class="mt-2 color-silver"><?=__('点击上传图片', 'young-bird')?></p>
              <input type="file" name="images[<?=$index?>]"<?=$editable? '' : ' disabled'?> class="custom-file-input">
              <img src="<?=$image?>?imageView2/1/w/640/h/480">
              <?php if ($editable): ?>
              <a href="<?php the_permalink(); ?>?delete_image=<?=urlencode($image)?>"><i class="fas fa-trash-alt"></i></a>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
          <?php if ($editable): for ($i=0; $i<5-count($images); $i++): ?>
          <div class="col-lg-2-4">
            <div class="upload-container custom-file-container d-flex justify-content-center align-items-center flex-column">
              <i class="fas fa-plus color-silver"></i>
              <p class="mt-2 color-silver"><?=__('点击上传图片', 'young-bird')?></p>
              <input type="file" name="images[]" class="custom-file-input">
              <img src="" class="d-none" alt="">
              <a href="#" class="delete d-none"><i class="fas fa-trash-alt"></i></a>
            </div>
          </div>
          <?php endfor; endif; ?>
        </div>
        <?php if ($editable): ?>
        <p class="mb-5 color-silver"><?=__('拖动图片来改变顺序', 'young-bird')?></p>
        <?php endif; ?>
        <div class="row">
          <div class="col-12">
            <button type="button" class="btn btn-secondary btn-block btn-lg btn-preview"><?=__('预览', 'young-bird')?></button>
            <div class="d-none preview-box">
              <a class="w-100" style="padding:10vh 20vw">
                <div class="row mx-auto justify-content-between">
                  <h3><?php the_title(); ?></h3>
                  <h4>YB<?=strtoupper($post->post_name)?></h4>
                </div>
                <div class="mt-3">
                  <?=wpautop($description)?>
                </div>
              </a>
              <a href="<?=get_the_post_thumbnail_url(get_the_ID())?>">
                <?php the_post_thumbnail('full'); ?>
              </a>
            </div>
          </div>
          <?php if ($editable): ?>
          <div class="col-12">
            <button type="submit" name="submit" class="btn btn-secondary btn-block btn-lg bg-body-grey"><?=__('上传', 'young-bird')?></button>
          </div>
          <?php endif; ?>
        </div>
      </form>
    </div>
<?php get_footer(); ?>
