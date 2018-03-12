<?php
if ($mobile = $_GET['send_code_to_mobile']) :
  // send mobile code to $_GET['send_code_to_mobile'] and save to wp_options
  send_sms_code($mobile, 'reset');

elseif ($email = $_GET['send_code_to_email']) :
  // send mobile code to $_GET['send_code_to_mobile'] and save to wp_options
  send_email_code($email);
else:
  if(isset($_POST['login'])){

    if ($_POST['reset_password'] !== $_POST['reset_password_confirm']) {
      exit(__('两次输入密码不一致，请返回修改', 'young-bird'));
    }

    if (isset($_POST['code']) && !verify_code($_POST['login'], $_POST['code'])) {
      exit(__('短信/邮箱验证码输入错误', 'young-bird'));
    }

    $user = get_user_by('login', $_POST['login']);

    if (!$user) {
      if (is_email($_POST['login'])) {
        $user = get_user_by('email', $_POST['login']);
      } elseif (is_numeric($_POST['login'])) {
        $user = get_users(array('meta_key' => 'mobile', 'meta_value' => $_POST['login']))[0];
      }
    }

    if (!$user) {
      exit(__('找不到这个用户', 'young-bird') . ' ' . $_POST['login']);
    }

    reset_password($user, $_POST['reset_password']);

    header('Location: ' . pll_home_url() . '/sign-in/?reset=true'); exit;
  }

get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-sign-up.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_忘记密码 <br>FORGET PASSWORD</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 sign-up">
      <div class="row align-items-center">
        <div class="col-md-12 d-none d-md-flex justify-content-center align-items-center logo">
          <img src="<?=get_stylesheet_directory_uri()?>/images/bird.jpg" alt="">
        </div>
        <div class="col-md-12">
          <form method="post">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="login" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?> / <?=__('手机', 'young-bird')?>">
              </div>
            </div>
            <!--<div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="captcha" class="form-control" placeholder="<?=__('输入验证码', 'young-bird')?>">
                <div class="input-group-append">
                  <span class="input-group-text">ee131m</span>
                  <button type="button" class="btn btn-outline-primary"><?=__('刷新', 'young-bird')?></button>
                </div>
              </div>
            </div>-->
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
                <input type="password" name="reset_password" class="form-control" placeholder="<?=__('重置密码', 'young-bird')?>（<?=__('数字或字母', 'young-bird')?>）">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" name="reset_password_confirm" class="form-control" placeholder="<?=__('确认重置密码', 'young-bird')?>">
              </div>
            </div>
            <button type="submit" class="btn btn-secondary btn-block btn-lg"><?=__('找回密码', 'young-bird')?></button>
            <div class="row justify-content-between pl-2 pr-2 mt-2">
              <div><a href="<?=pll_home_url()?>sign-in/" class="text-underline"><?=__('返回登录页面', 'young-bird')?></a></div>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php get_footer(); endif;
