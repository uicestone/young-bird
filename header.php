<!doctype html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, shrink-to-fit=no">
    <title><?php wp_title('-', true, 'right'); bloginfo('sitename'); ?></title>
    <?php wp_head(); ?>
  </head>
  <body>
    <!-- Header -->
    <div class="container">
      <nav class="navbar navbar-light navbar-expand-lg">
        <a class="navbar-brand" href="<?=site_url()?>">
          <img src="<?=get_stylesheet_directory_uri()?>/images/logo.png" width="267" height="58" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item mr-lg-3 mr-xl-5 active">
              <a class="nav-link" href="/category/news/">新 闻</a>
            </li>
            <li class="nav-item mr-lg-3 mr-xl-5">
              <a class="nav-link" href="/event/">竞 赛</a>
            </li>
            <li class="nav-item mr-lg-3 mr-xl-5">
              <a class="nav-link" href="/judge/">大 咖</a>
            </li>
            <li class="nav-item mr-lg-3 mr-xl-5">
              <a class="nav-link" href="/event/?history">历 史</a>
            </li>
            <li class="nav-item mr-lg-3 mr-xl-5">
              <a class="nav-link" href="javascript:alert('院校暂未开放，敬请期待')">院 校</a>
            </li>
          </ul>
          <form class="form-inline">
            <a href="/?s="><i class="fas fa-search"></i></a>
            <a href="/sign-up/" class="btn btn-link">注册</a>
            <span>|</span>
            <a href="/sign-in/" class="btn btn-link">登录</a>
            <!--<a href="#" class="btn btn-link pl-0">EN</a>-->
          </form>
        </div>
      </nav>
    </div>
