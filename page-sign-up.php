<?php
if ($_GET['send_code_to_mobile']) :
  // send mobile code to $_GET['send_code_to_mobile'] and save to wp_options
else:

  if(isset($_POST['login'])){

    if ($_POST['password'] !== $_POST['password_confirm']) {
      exit('两次输入密码不一致，请返回修改');
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
      exit(array_values($user_id->errors)[0][0]);
    }

    if (is_numeric($_POST['login'])) {
      add_user_meta($user_id, 'mobile', $_POST['login']);
    }

    wp_set_auth_cookie($user_id, true);
    wp_set_current_user($user_id);

    header('Location: ' . ($_GET['intend'] ?: '/')); exit;
  }

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
            <!--<div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="captcha" class="form-control" placeholder="输入验证码">
                <div class="input-group-append">
                  <span class="input-group-text">EE131M</span>
                  <button type="button" class="btn btn-outline-primary">刷新</button>
                </div>
              </div>
            </div>-->
            <!--show if [login] is mobile-->
            <!--GET ?send_code_to_mobile=[mobile]-->
            <!--<div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="code" class="form-control" placeholder="输入短信验证码">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-primary">发送短信验证码</button>
                </div>
              </div>
            </div>-->
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" name="password" class="form-control" placeholder="密码（数字或字母）">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" name="password_confirm" class="form-control" placeholder="确认密码">
              </div>
            </div>
            <p class="text-right">
              <small>注册即视为同意 <a href="<?=site_url()?>/privacy-policy/" class="text-underline">隐私条款</a> 和 <a href="<?=site_url()?>/service-term/" class="text-underline">服务条款</a></small>
            </p>
            <button type="submit" class="btn btn-lg btn-secondary btn-block">注册</button>
          </form>
        </div>
      </div>
    </div>
<?php endif;
get_footer();
endif;
