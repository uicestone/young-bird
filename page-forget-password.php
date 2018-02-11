<?php
if ($_GET['send_code_to_mobile']):
  // send mobile code to $_GET['send_code_to_mobile'] and save to wp_options
else:
  get_header();
    if (isset($_GET['email'])) :
      get_template_part('page-forget-password-email');
    elseif (isset($_GET['email-verify'])) :
      get_template_part('page-forget-password-email-verify');
    else: ?>
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
                <input type="text" name="mobile" class="form-control" placeholder="手机">
              </div>
            </div>
            <!--<div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="captcha" class="form-control" placeholder="输入验证码">
                <div class="input-group-append">
                  <span class="input-group-text">ee131m</span>
                  <button type="button" class="btn btn-outline-secondary">刷新</button>
                </div>
              </div>
            </div>-->
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="code" class="form-control" placeholder="输入短信验证码">
                <div class="input-group-append">
                  <!--GET ?send_code_to_mobile=[mobile]-->
                  <button type="button" class="btn btn-outline-secondary">发送短信验证码</button>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-secondary btn-block btn-lg">找回密码</button>
            <div class="row justify-content-between pl-2 pr-2 mt-2">
              <div><a href="/login/" class="text-underline">返回登录页面</a></div>
              <div><a href="/forget-password/?email" class="text-underline">邮箱找回</a></div>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php endif;
get_footer();
endif;
