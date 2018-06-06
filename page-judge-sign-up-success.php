    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-partners.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_大 咖 <br>JUDGE CENTER</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 sign-up">
      <div class="row align-items-center">
        <div class="col-md-12 d-none d-md-flex justify-content-center align-items-center logo">
          <img src="<?=get_stylesheet_directory_uri()?>/images/bird.jpg" alt="">
        </div>
        <div class="col-md-12">
          <div class="msg text-center">
            <img src="<?=get_stylesheet_directory_uri()?>/images/icon-check.png" alt="">
            <h3 class="mt-3"><?=__('成功激活评委账号', 'young-bird')?>！</h3>
            <!--<p class="mb-2"><?=__('您即将进入评委中心，如果未自动跳转，请点击以下链接', 'young-bird')?></p>-->
            <a href="<?=pll_home_url()?>judge-center/"><u><?=__('进入评委中心', 'young-bird')?></u></a>
          </div>
          <div class="qr text-center">
            <img src="<?=get_stylesheet_directory_uri()?>/images/qrcode.jpg" alt="">
            <p class="font-weight-bold"><?=__('扫码关注', 'young-bird')?><br><?=__('关注', 'young-bird')?> YoungBird <?=__('公众号', 'young-bird')?><br><?=__('接收更多资讯', 'young-bird')?></p>
          </div>
          <a href="<?=pll_home_url()?>" class="btn btn-secondary btn-block btn-lg"><?=__('进入网站首页', 'young-bird')?></a>
        </div>
      </div>
    </div>
