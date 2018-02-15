<?php
redirect_login();
$user = wp_get_current_user();

$sign_up_fields = array ('mobile', 'identity', 'birthday', 'constellation', 'hobby', 'address', 'company', 'department', 'title', 'id_card', 'school', 'major');
foreach ($sign_up_fields as $field) {
  $$field =  get_user_meta($user->ID, $field, true);
}

if (isset($_POST['submit'])) {

  foreach ($sign_up_fields as $field) {
    if (isset($_POST[$field])) {
      update_user_meta($user->ID, $field, $_POST[$field]);
    }
  }

  if ($_POST['user_name']) {
    $user->display_name = $_POST['user_name'];
    update_user_meta($user->ID, 'name', $_POST['name']);
  }
  if ($_POST['email']) {
    $user->user_email = $_POST['email'];
  }
  if ($_POST['user_name'] || $_POST['email']) {
    wp_update_user($user);
  }
  if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
  }

  $avatar = wp_handle_upload($_FILES['avatar'], array ('test_form' => false));

  if ($avatar['url']) {
    update_user_meta($user->ID, 'avatar', $avatar['url']);
  }

  header('Location: ' . get_the_permalink()); exit;
}

get_header(); the_post(); if (isset($_GET['event'])):

  include(locate_template('page-user-center-event.php'));

else: ?>

    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-help-center.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_用户中心 <br>USER CENTER</h1>
      </div>
    </div>
    <!-- Menu -->
    <div class="container-fluid user-center-menu">
      <div class="container">
        <ul>
          <li class="active"><a href="<?php the_permalink(); ?>"><?=__('个人信息', 'young-bird')?></a></li>
          <li><a href="<?php the_permalink(); ?>?event"><?=__('我的竞赛', 'young-bird')?></a></li>
          <li><a href="<?=site_url()?>/message/"><?=__('消息', 'young-bird')?><i></i></a></li>
        </ul>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body">
      <form method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-12">
            <div class="row mx-auto info-container">
              <div class="col-6">
                <div class="custom-file-container d-flex justify-content-center align-items-center flex-column">
                  <i class="fas fa-plus"></i>
                  <input type="file" name="avatar" class="custom-file-input">
                  <?php if ($avatar = get_user_meta($user->ID, 'avatar', true)): ?>
                  <img src="<?=$avatar?>">
                  <?php else: ?>
                  <img src="" class="d-none">
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-18">
                <div class="form-group">
                  <div class="input-group input-group-lg">
                    <input type="text" name="user_name" value="<?=$user->display_name?>" class="form-control" placeholder="<?=__('姓名', 'young-bird')?>">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-lg">
                    <input type="text" name="mobile" value="<?=$mobile?>" class="form-control" placeholder="<?=__('手机', 'young-bird')?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="identity" value="<?=$identity?>" class="form-control" placeholder="<?=__('身份', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="school" value="<?=$school?>" class="form-control" placeholder="<?=__('学校', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="constellation" value="<?=$constellation?>" class="form-control" placeholder="<?=__('星座', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="address" value="<?=$address?>" class="form-control" placeholder="<?=__('地址', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="department" value="<?=$department?>" class="form-control" placeholder="<?=__('部门', 'young-bird')?>">
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="id_card" value="<?=$id_card?>" class="form-control" placeholder="<?=__('身份证号', 'young-bird')?>/<?=__('护照号', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="email" value="<?=$user->user_email?>" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="birthday" value="<?=$birthday?>" class="form-control" placeholder="<?=__('生日', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="major" value="<?=$major?>" class="form-control" placeholder="<?=__('专业', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="hobby" value="<?=$hobby?>" class="form-control" placeholder="<?=__('兴趣', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="company" value="<?=$company?>" class="form-control" placeholder="<?=__('公司', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" title="title" value="<?=$title?>" class="form-control" placeholder="<?=__('职位', 'young-bird')?>">
              </div>
            </div>
          </div>
        </div>
        <div class="row mx-auto justify-content-end">
          <button type="submit" name="submit" class="btn btn-lg btn-secondary btn-common"><?=__('保存', 'young-bird')?></button>
        </div>
      </form>
    </div>
<?php endif; get_footer(); ?>
