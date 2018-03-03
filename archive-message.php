<?php get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-help-center.jpg) center center / cover no-repeat">
      <div class="container">
        <?php if (current_user_can('judge_works')): ?>
        <h1>_大咖中心 <br>JUDGE CENTER</h1>
        <?php else: ?>
        <h1>_用户中心 <br>USER CENTER</h1>
        <?php endif; ?>
      </div>
    </div>
    <!-- Menu -->
    <div class="container-fluid user-center-menu">
      <div class="container">
        <ul>
          <li><a href="<?=pll_home_url()?>user-center/"><?=__('个人信息', 'young-bird')?></a></li>
          <li><a href="<?php the_permalink(); ?>?event"><?=__('我的竞赛', 'young-bird')?></a></li>
          <li><a href="<?php the_permalink(); ?>?activity"><?=__('我的活动', 'young-bird')?></a></li>
          <li class="active">
            <a href="<?=pll_home_url()?>message/"><?=__('消息', 'young-bird')?>
              <?php if ($has_unread_message = get_user_meta(get_current_user_id(), 'has_unread_message', true)): ?><i></i><?php endif; ?>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body">
      <div class="row mx-auto mb-2 justify-content-between">
        <h4>全部消息：<?=$wp_query->found_posts?></h4>
        <h4>未读消息：<?=get_user_meta(get_the_ID(), 'unread_messages', true) ?: 0?></h4>
      </div>
      <ul class="message-list pl-0">
        <?php while(have_posts()): the_post(); ?>
        <li class="px-5 pt-4 pb-2">
          <h3><?php the_title(); ?></h3>
          <?php the_content(); ?>
        </li>
        <?php endwhile; ?>
      </ul>
      <nav class="mt-5">
        <?=paginate_links(array ('type' => 'list', 'prev_text' => '<i class="fas fa-angle-left"></i>', 'next_text' => '<i class="fas fa-angle-right"></i>', 'before_page_number' => '0'))?>
      </nav>
    </div>
<?php get_footer(); ?>
