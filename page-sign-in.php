<?php

if(isset($_POST['login'])){
  $user = wp_authenticate($_POST['login'], $_POST['password']);

  if(is_a($user, 'WP_Error')){
    echo '<meta charset="utf-8">';
    echo array_values($user->errors)[0][0];
    exit;
  }

  wp_set_auth_cookie($user->ID, isset($_POST['remember']));
  wp_set_current_user($user->ID);

  header('Location: ' . ($_GET['intend'] ?: '/')); exit;
}

if(isset($_GET['logout'])){
  wp_logout();
  header('Location: ' . site_url());
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
          <form method="post">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="login" class="form-control" placeholder="邮箱/手机">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" name="password" class="form-control" placeholder="密码（12位数字或字母）">
              </div>
            </div>
            <button type="submit" class="btn btn-secondary btn-block btn-lg">登录</button>
            <div class="row justify-content-between pl-2 pr-2 mt-2">
              <div>没有账号？<a href="<?=site_url()?>/sign-up/" class="text-underline">现在注册</a></div>
              <div><a href="<?=site_url()?>/forget-password/" class="text-underline">忘记密码</a></div>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php get_footer(); ?>
