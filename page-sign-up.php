<?php
if (isset($_GET['send_code_to_mobile']) && $mobile = $_GET['send_code_to_mobile']) :
  // send mobile code to $_GET['send_code_to_mobile'] and save to wp_options
  send_sms_code($mobile, 'register');

elseif (isset($_GET['send_code_to_email']) && $email = $_GET['send_code_to_email']) :
  // send mobile code to $_GET['send_code_to_mobile'] and save to wp_options
  send_email_code($email);
else:

  try {

    if(isset($_POST['login'])){

      if ($_POST['password'] !== $_POST['password_confirm']) {
        throw new Exception(__('两次输入密码不一致', 'young-bird'));
      }

      if (isset($_POST['code']) && !verify_code($_POST['login'], $_POST['code'])) {
        throw new Exception(__('短信/邮箱验证码输入错误', 'young-bird'));
      }

      if (strlen($_POST['password']) < 6) {
        throw new Exception(__('密码应至少由6位数字或字母组成', 'young-bird'));
      }

      $user_data = array(
        'user_pass' => $_POST['password'],
        'user_login' => $_POST['login'],
        'user_registered' => date('Y-m-d H:i:s'),
        'show_admin_bar_front' => false
      );

      if (is_email($_POST['login'])) {
        $user_data['user_email'] = $_POST['login'];
      }

      $user_id = wp_insert_user($user_data);

      if(is_a($user_id, 'WP_Error')){
        throw new Exception(array_values($user_id->errors)[0][0]);
      }

      if (is_numeric($_POST['login'])) {
        add_user_meta($user_id, 'mobile', $_POST['login']);
      }

      add_user_meta($user_id, 'lang', pll_current_language());

      if (isset($_GET['wx_unionid'])) {
        add_user_meta($user_id, 'wx_unionid', $_GET['wx_unionid']);
      }

      wp_set_auth_cookie($user_id, true);
      wp_set_current_user($user_id);

      send_message($user_id, 'successfully-registered', array('username' => $_POST['login']));

      header('Location: ' . ($_GET['intend'] ?: pll_home_url() . 'sign-up/?success')); exit;
    }
  }
  catch (Exception $e) {
    $form_error = $e->getMessage();
  }

  $wx = new WeixinAPI();

  if (isset($_GET['code']) && $oauth_info = $wx->get_oauth_info()) {
    header('Location: ' . pll_home_url() . 'sign-up/?wx_unionid=' . $oauth_info->unionid); exit;
  }

  if (isset($_GET['wx_unionid'])) {
    $user_id = $wpdb->get_var("select user_id from {$wpdb->usermeta} where meta_key = 'wx_unionid' and meta_value = '{$_GET['wx_unionid']}'");
    if ($user_id) {
      $user = get_user_by('ID', $user_id);
      wp_set_auth_cookie($user_id);
      if (in_array('judge', $user->roles) && !get_user_meta($user->ID, 'signed_up', true)) {
        header('Location: ' . pll_home_url() . 'judge-sign-up/');
        exit;
      }

      header('Location: ' . ($_GET['intend'] ?: pll_home_url()));
      exit;
    }
  }

  $user_agreement = get_posts(array('name' => 'user-agreement'))[0];

  get_header();
    if (isset($_GET['success'])) :
      get_template_part('page-sign-up-success');
    else: ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-sign-up.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_注册 <br>SIGN UP</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-32 mt-md-7 pb-5 pb-md-7 sign-up">
      <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-center align-items-center logo">
          <img src="<?=get_stylesheet_directory_uri()?>/images/bird.jpg" alt="">
        </div>
        <div class="col-md-12 offset-md-2">
          <?php if (isset($form_error)): ?>
          <div class="alert alert-danger"><?=$form_error?></div>
          <?php endif; ?>
          <form method="post" accept-charset="UTF-8">
            <?php if (empty($_GET['wx_unionid']) && pll_current_language() === 'zh'): ?>
            <div class="d-none d-lg-flex justify-content-end align-items-end third-party">
              <span>第三方登录</span>
              <a href="<?=$wx->generate_web_qr_oauth_url(pll_home_url() . 'sign-up/')?>" class="button-share-item button-weixin"></a>
            </div>
            <?php endif; ?>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="login" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?><?php if (pll_current_language()=='zh'){ ?> / <?=__('手机', 'young-bird')?><?php } ?>">
              </div>
            </div>
            <!--<div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="captcha" class="form-control" placeholder="<?=__('输入验证码', 'young-bird')?>">
                <div class="input-group-append">
                  <span class="input-group-text">EE131M</span>
                  <button type="button" class="btn btn-outline-primary"><?=__('刷新', 'young-bird')?></button>
                </div>
              </div>
            </div>-->
            <!--show if [login] is mobile-->
            <!--GET ?send_code_to_mobile=[mobile]-->
            <div class="form-group verify-code login-is-mobile collapse">
              <div class="input-group input-group-lg">
                <input type="text" name="code" class="form-control" placeholder="<?=__('输入短信验证码', 'young-bird')?>">
                <div class="input-group-append">
                  <button type="button" class="btn btn-secondary send-verify-code"><?=__('发送短信验证码', 'young-bird')?></button>
                </div>
              </div>
            </div>
            <!--show if [login] is email-->
            <div class="form-group verify-code login-is-email collapse">
              <div class="input-group input-group-lg">
                <input type="text" name="code" class="form-control" placeholder="<?=__('输入邮箱验证码', 'young-bird')?>">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-primary send-verify-code"><?=__('发送邮箱验证码', 'young-bird')?></button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" name="password" class="form-control" placeholder="<?=__('密码', 'young-bird')?>（<?=__('数字或字母', 'young-bird')?>）">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" name="password_confirm" class="form-control" placeholder="<?=__('确认密码', 'young-bird')?>">
              </div>
            </div>
            <p class="text-right">
              <small><?=__('注册即视为同意', 'young-bird')?> <a href="<?=get_permalink($user_agreement->ID)?>" class="text-underline"><?=__('用户协议', 'young-bird')?></a></small>
            </p>
            <button type="submit" class="btn btn-lg btn-secondary btn-block"><?=__('注册', 'young-bird')?></button>
          </form>
        </div>
      </div>
    </div>
<?php endif;
get_footer();
endif;
