<!doctype html>
<?php  $ttttrank=get_post(get_the_ID());?>
<html lang="<?=pll_current_language('locale')?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="YoungBirdPlan 设计师 创新 年轻 高品质竞赛平台" />
      <?php if($ttttrank->post_type=='case') :?>
          <meta name="description" content="<?php print wp_trim_words($ttttrank->post_content,100); ?>" />
          <meta name="sharetitle" content="<?php print wp_trim_words($ttttrank->post_title,100); ?>" />
          <meta name="shareimg" content="<?php print wp_get_attachment_image_url(get_post_meta($ttttrank->ID,'image',true),array('280,210'));?>" />
      <?php elseif($ttttrank->post_type=='post') :?>
          <meta name="description" content="<?php print wp_trim_words($ttttrank->post_content,100); ?>" />
          <meta name="sharetitle" content="<?php print wp_trim_words($ttttrank->post_title,100); ?>" />
          <meta name="shareimg" content="<?php print get_the_post_thumbnail_url($ttttrank->ID)?>" />
      <?php elseif($ttttrank->post_type=='event') :?>
          <meta name="description" content="<?php print wp_trim_words(get_the_excerpt($ttttrank->ID),100); ?>" />
          <meta name="sharetitle" content="<?php print wp_trim_words($ttttrank->post_title,100); ?>" />
          <meta name="shareimg" content="<?php print get_the_post_thumbnail_url($ttttrank->ID)?>" />
      <?php else:?>
          <meta name="description" content="<?php is_single() ? print(get_the_excerpt()) : bloginfo('description'); ?>" />
      <?php endif;?>

      <?php $event_id = get_post_meta(get_the_ID(), 'event', true);?>
      <style type=text/css >
          .fancybox-image-wrap:after
          {
              content:' ';
              background-image: url("<?php echo wp_get_attachment_image_url(get_post_meta($event_id,'water',true),'vga');?>");
              width: 100%;
              height: 100%;
              position: absolute;
              left: 0;
              top: 0;
              z-index: 201;
          }
      </style>

    <link rel="shortcut icon" type="image/x-icon" href="<?=get_stylesheet_directory_uri()?>/images/favicon.ico">
    <!-- For Chrome for Android: -->
    <link rel="icon" sizes="192x192" href="<?=get_stylesheet_directory_uri()?>/images/touch-icon-192x192.png">
    <!-- For iPhone 6 Plus with @3× display: -->
    <link rel="apple-touch-icon-precomposed" sizes="180x180" href="<?=get_stylesheet_directory_uri()?>/images/apple-touch-icon-180x180-precomposed.png">
    <!-- For iPad with @2× display running iOS ≥ 7: -->
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?=get_stylesheet_directory_uri()?>/images/apple-touch-icon-152x152-precomposed.png">
    <!-- For iPhone with @2× display running iOS ≥ 7: -->
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?=get_stylesheet_directory_uri()?>/images/apple-touch-icon-120x120-precomposed.png">
    <!-- For the iPad mini and the first- and second-generation iPad (@1× display) on iOS ≥ 7: -->
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?=get_stylesheet_directory_uri()?>/images/apple-touch-icon-76x76-precomposed.png">
    <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
    <link rel="apple-touch-icon-precomposed" href="<?=get_stylesheet_directory_uri()?>/images/apple-touch-icon-precomposed.png"><!-- 57×57px -->
    <title><?php echo preg_replace('/^  – /', '', strip_tags(html_entity_decode(wp_title('-', false, 'right')))); bloginfo('sitename'); ?></title>
    <?php wp_head(); ?>
  </head>
  <?php



  ?>
  <body <?php body_class('lang-' . pll_current_language()); ?> <?php if($ttttrank->post_type=='rank1') echo 'oncontextmenu=\'return false\'';?>>
    <!-- Header -->
    <div class="container">
      <nav class="navbar navbar-light navbar-expand-lg">
        <a class="navbar-brand" href="<?=pll_home_url()?>">
          <img src="<?=get_stylesheet_directory_uri()?>/images/logo5.jpg" width="267" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item mr-lg-3 mr-xl-5">
                  <a class="nav-link" href="<?=pll_home_url()?>event/"><?=__('嫩鸟计划', 'young-bird')?></a>
              </li>
            <li class="nav-item mr-lg-3 mr-xl-5 active">
              <a class="nav-link" href="<?=pll_home_url()?>case/"><?=__('专 题', 'young-bird')?></a>
            </li>
              <li class="nav-item mr-lg-3 mr-xl-5">
                  <a class="nav-link" href="<?=pll_home_url()?>event/?history"><?=__('往 届 作 品', 'young-bird')?></a>
              </li>
            <li class="nav-item mr-lg-3 mr-xl-5">
              <a class="nav-link" href="<?=pll_home_url()?>judge/"><?=__('大 咖', 'young-bird')?></a>
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
               <a href="<?=pll_home_url()?>campus" class="b2zz">成为站长</a>

            <?php if (function_exists('pll_the_languages')): ?>
            <ul class="language-swicher mb-0">
              <?php pll_the_languages(array ('hide_current' => true, 'display_names_as' => 'slug')); ?>
            </ul>
            <?php endif; ?>
          </form>
        </div>
      </nav>
    </div>
