<?php

$user = wp_get_current_user();

$sign_up_fields = array ('mobile', 'birthday', 'school', 'major', 'identities', 'titles', 'awards');
foreach ($sign_up_fields as $field) {
  $$field =  get_user_meta($user->ID, $field, true);
}

if (isset($_POST['sign_up_step'])) {

  foreach ($sign_up_fields as $field) {
    if (isset($_POST[$field])) {
      update_user_meta($user->ID, $field, $_POST[$field]);
    }
  }
  if ($_POST['institutions'] && $_POST['titles']) {
    $titles = array_map(function ($institution, $title) {
      return $institution . '/' . $title;
    }, $_POST['institutions'], $_POST['titles']);
    update_user_meta($user->ID, 'titles', $titles);
  }

  if ($_POST['judge_name']) {
    $user->display_name = $_POST['judge_name'];
    update_user_meta($user->ID, 'name', $_POST['judge_name']);
  }
  if ($_POST['email']) {
    $user->user_email = $_POST['email'];
  }
  if ($_POST['judge_name'] || $_POST['email']) {
    wp_update_user($user);
  }

  header('Location: ' . get_the_permalink() . '?step=' . $_POST['sign_up_step']); exit;
}

if (isset($_POST['sign_up_success'])) {
  if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
  }

  $avatar = wp_handle_upload($_FILES['avatar'], array ('test_form' => false));
  $resume = wp_handle_upload($_FILES['resume'], array ('test_form' => false));
  update_user_meta($user->ID, 'avatar', $avatar['url']);
  update_user_meta($user->ID, 'resume', $resume['url']);
  update_user_meta($user->ID, 'description', $_POST['bio']);
  update_user_meta($user->ID, 'signed_up', 'yes');

  header('Location: ' . get_the_permalink() . '?success'); exit;
}

$user_agreement = get_posts(array('name' => 'user-agreement'))[0];

get_header();
    if (isset($_GET['step'])) :
      include(locate_template('page-judge-sign-up-step-' . $_GET['step'] . '.php'));
    elseif (isset($_GET['success'])) :
      include(locate_template('page-judge-sign-up-success.php'));
    else: ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-partners.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_大 咖 <br>PARTNERS</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 sign-up">
      <div class="row align-items-center">
        <div class="col-md-12 d-none d-md-flex justify-content-center align-items-center logo">
          <img src="<?=get_stylesheet_directory_uri()?>/images/bird.jpg" alt="">
        </div>
        <div class="col-md-12">
          <h3 class="text-center"><?=__('登录成功', 'young-bird')?></h3>
          <p class="text-center mb-4"><strong><?=__('请填写下列信息来激活您的账号', 'young-bird')?></strong></p>
          <form method="post" accept-charset="UTF-8">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="judge_name" value="<?=$user->display_name?>" class="form-control" placeholder="<?=__('姓名', 'young-bird')?>" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="mobile" value="<?=$mobile?>" class="form-control" placeholder="<?=__('手机号', 'young-bird')?>（<?=__('选填', 'young-bird')?>）">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="email" name="email" value="<?=$user->user_email?>" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?>（<?=__('选填', 'young-bird')?>）">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="birthday" value="<?=$birthday?>" class="form-control datepicker" placeholder="<?=__('生日信息', 'young-bird')?>（<?=__('选填', 'young-bird')?>）" autocomplete="off">
              </div>
            </div>
            <p class="text-right">
              <small><?=__('激活即视为同意', 'young-bird')?> <a href="<?=get_permalink($user_agreement->ID)?>" class="text-underline"><?=__('用户协议', 'young-bird')?></a></small>
            </p>
            <button type="submit" name="sign_up_step" value="2" class="btn btn-secondary btn-block btn-lg"><?=__('下一步', 'young-bird')?></button>
          </form>
        </div>
      </div>
    </div>
<?php endif;
get_footer();
