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
          <form method="post" action="/forget-password/?email-verify">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="email" name="email" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?>">
              </div>
            </div>
            <button type="submit" class="btn btn-secondary btn-block btn-lg"><?=__('找回密码', 'young-bird')?></button>
            <div class="row justify-content-between pl-2 pr-2 mt-2">
              <div><a href="<?=site_url()?>/login/" class="text-underline"><?=__('返回登录页面', 'young-bird')?></a></div>
              <div><a href="<?=site_url()?>/forget-password/" class="text-underline"><?=__('手机找回', 'young-bird')?></a></div>
            </div>
          </form>
        </div>
      </div>
    </div>
