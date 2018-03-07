<!doctype html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="YoungBirdPlan 设计师 创新 年轻 高品质竞赛平台" />
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?=get_stylesheet_directory_uri()?>/images/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="<?=get_stylesheet_directory_uri()?>/images/logo-114.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?=get_stylesheet_directory_uri()?>/images/logo-114.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?=get_stylesheet_directory_uri()?>/images/logo-144.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?=get_stylesheet_directory_uri()?>/images/logo-144.png" />
    <title><?php echo preg_replace('/^  – /', '', strip_tags(html_entity_decode(wp_title('-', false, 'right')))); bloginfo('sitename'); ?></title>
    <?php wp_head(); ?>
  </head>
  <body>
    <!-- Header -->
    <div class="container">
      <nav class="navbar navbar-light navbar-expand-lg">
        <a class="navbar-brand" href="<?=pll_home_url()?>">
          <img src="<?=get_stylesheet_directory_uri()?>/images/logo.svg" width="267" height="58" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item mr-lg-3 mr-xl-5 active">
              <a class="nav-link" href="<?=pll_home_url()?>category/news<?=language_slug_suffix()?>/"><?=__('新 闻', 'young-bird')?></a>
            </li>
            <li class="nav-item mr-lg-3 mr-xl-5">
              <a class="nav-link" href="<?=pll_home_url()?>event/"><?=__('竞 赛', 'young-bird')?></a>
            </li>
            <li class="nav-item mr-lg-3 mr-xl-5">
              <a class="nav-link" href="<?=pll_home_url()?>judge/"><?=__('大 咖', 'young-bird')?></a>
            </li>
            <li class="nav-item mr-lg-3 mr-xl-5">
              <a class="nav-link" href="<?=pll_home_url()?>event/?history"><?=__('历 史', 'young-bird')?></a>
            </li>
          </ul>
          <form class="form-inline mt-md-4 mt-lg-0">
            <a href="<?=pll_home_url()?>?s=" class="search"><i class="fas fa-search"></i></a>
            <?php if (is_user_logged_in()): ?>
            <a href="<?=pll_home_url() . (current_user_can('judge_works') ? 'judge-center/' : 'user-center/')?>" class="btn btn-link"><?=wp_get_current_user()->display_name?></a>
            <a href="<?=pll_home_url()?>sign-in/?logout=true" class="btn btn-link"><?=__('退出登录', 'young-bird')?></a>
            <?php else: ?>
            <a href="<?=pll_home_url()?>sign-up/" class="btn btn-link"><?=__('注册', 'young-bird')?></a>
            <span>|</span>
            <a href="<?=pll_home_url()?>sign-in/" class="btn btn-link"><?=__('登录', 'young-bird')?></a>
            <?php endif; ?>
            <?php if (function_exists('pll_the_languages')): ?>
            <ul class="language-swicher mb-0">
              <?php pll_the_languages(array ('hide_current' => true, 'display_names_as' => 'slug')); ?>
            </ul>
            <?php endif; ?>
          </form>
        </div>
      </nav>
    </div>
