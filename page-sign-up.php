<?php get_header();
    if (isset($_GET['success'])) :
      get_template_part('page-sign-up-success');
    else: ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(images/banner-sign-up.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_注册 <br>SIGN UP</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 sign-up">
      <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-center align-items-center logo">
          <img src="images/bird.jpg" alt="">
        </div>
        <div class="col-md-12 offset-md-2">
          <form>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="邮箱/手机">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="输入验证码">
                <div class="input-group-append">
                  <span class="input-group-text">EE131M</span>
                  <button type="button" class="btn btn-outline-secondary">刷新</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="输入短信验证码">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary">发送短信验证码</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" class="form-control" placeholder="密码（12位数字或字母）">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" class="form-control" placeholder="确认密码">
              </div>
            </div>
            <p class="text-right">
              <small>注册即视为同意 <a href="" class="text-underline">隐私条款</a> 和 <a href="" class="text-underline">服务条款</a></small>
            </p>
            <button type="button" class="btn btn-lg btn-secondary btn-block">注册</button>
          </form>
        </div>
      </div>
    </div>
<?php endif;
get_footer();
