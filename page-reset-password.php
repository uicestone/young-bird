<?php get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(images/banner-sign-up.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_登录 <br>SIGN IN</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 sign-up">
      <div class="row align-items-center">
        <div class="col-md-12 d-none d-md-flex justify-content-center align-items-center logo">
          <img src="images/bird.jpg" alt="">
        </div>
        <div class="col-md-12">
          <form>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" class="form-control" placeholder="新密码">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="password" class="form-control" placeholder="确认密码">
              </div>
            </div>
            <button type="button" class="btn btn-secondary btn-block btn-lg">确认</button>
            <div class="row justify-content-between pl-2 pr-2 mt-2">
              <div><a href="#" class="text-underline">返回登录页面</a></div>
              <div><a href="#" class="text-underline">手机找回</a></div>
            </div>
          </form>
        </div>
      </div>
    </div>
<?php get_footer(); ?>
