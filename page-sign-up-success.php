    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-sign-up.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_注册 <br>SIGN UP</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-48 mt-md-7 pb-48 pb-md-7 sign-up sign-up-success">
      <div class="row align-items-center">
        <div class="col-md-12 d-none d-md-flex justify-content-center align-items-center logo">
          <img src="<?=get_stylesheet_directory_uri()?>/images/bird.jpg" alt="">
        </div>
        <div class="col-md-12">
          <div class="msg text-center mb-4">
            <img src="<?=get_stylesheet_directory_uri()?>/images/icon-check.png" alt="" class="checkicon">
            <h3 class="mt-3"><?=__('恭喜注册成功', 'young-bird')?>!</h3>
            <a href="<?=pll_home_url()?>user-center/"><?=__('请至用户中心完善您的资料', 'young-bird')?></a>
          </div>
          <div class="qr text-center">
            <img src="<?=get_stylesheet_directory_uri()?>/images/qrcode.jpg" alt="">
            <p class="font-weight-bold"><?=__('扫码关注', 'young-bird')?><br><?=__('关注', 'young-bird')?> YoungBird <?=__('公众号', 'young-bird')?><br><?=__('接收更多资讯', 'young-bird')?></p>
          </div>
          <div class="row justify-content-between">
            <div class="col-md-24 mt-2">
              <a href="<?=pll_home_url()?>" class="btn btn-secondary btn-block btn-lg"><?=__('进入网站', 'young-bird')?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
