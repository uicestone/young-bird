<?php
try {

  if (isset($_POST['login'])) {
    $user = wp_authenticate($_POST['login'], $_POST['password']);

    if (is_a($user, 'WP_Error')) {
      throw new Exception(array_values($user->errors)[0][0]);
    }

    wp_set_auth_cookie($user->ID, isset($_POST['remember']));
    wp_set_current_user($user->ID);

    if (in_array('judge', $user->roles) && !get_user_meta($user->ID, 'signed_up', true)) {
      header('Location: ' . pll_home_url() . 'judge-sign-up/');
      exit;
    }

    header('Location: ' . ($_GET['intend'] ?: pll_home_url()));
    exit;
  }

  if (isset($_GET['logout'])) {
    wp_logout();
    header('Location: ' . pll_home_url());
  }
}
catch (Exception $e) {
  $form_error = $e->getMessage();
}

$wx = new WeixinAPI();

if (isset($_GET['code']) && $oauth_info = $wx->get_oauth_info()) {
  header('Location: ' . pll_home_url() . 'sign-in/?wx_unionid=' . $oauth_info->unionid); exit;
}

if (isset($_GET['wx_unionid'])) {
  $user_id = $wpdb->get_var("select user_id from {$wpdb->usermeta} where meta_key = 'wx_unionid' and meta_value = '{$_GET['wx_unionid']}'");
  if ($user_id) {
    $user = get_user_by('ID', $user_id);
    wp_set_auth_cookie($user->ID);
    if (in_array('judge', $user->roles) && !get_user_meta($user->ID, 'signed_up', true)) {
      header('Location: ' . pll_home_url() . 'judge-sign-up/');
      exit;
    }

    header('Location: ' . ($_GET['intend'] ?: pll_home_url()));
    exit;
  }
}

get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-sign-up.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_登录 <br>SIGN IN</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 sign-up">
      <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-center align-items-center logo">
          <img src="<?=get_stylesheet_directory_uri()?>/images/bird.jpg" alt="">
        </div>
        <div class="col-md-12 offset-md-2">
          <?php if (isset($form_error)): ?>
          <div class="alert alert-danger"><?=$form_error?></div>
          <?php endif; ?>
          <form method="post">
            <div class="d-none d-block-lg d-flex justify-content-end align-items-end third-party">
              <span>第三方登录</span>
              <a href="<?=$wx->generate_web_qr_oauth_url(pll_home_url() . 'sign-in/')?>" class="button-share-item button-weixin"></a>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="login" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?><?php if (pll_current_language()=='zh'){ ?> / <?=__('手机', 'young-bird')?><?php } ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" name="password" class="form-control" placeholder="<?=__('密码', 'young-bird')?>（<?=__('包含数字和字母', 'young-bird')?>）">
              </div>
            </div>
            <button type="submit" class="btn btn-secondary btn-block btn-lg"><?=__('登录', 'young-bird')?></button>
            <div class="row mx-auto justify-content-between mt-2 small-tip">
              <div><?=__('没有账号？', 'young-bird')?><a href="<?=pll_home_url()?>sign-up/" class="text-underline"><?=__('现在注册', 'young-bird')?></a></div>
              <div><a href="<?=pll_home_url()?>forget-password/" class="text-underline"><?=__('忘记密码', 'young-bird')?></a></div>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php get_footer(); ?>
