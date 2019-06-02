<?php
if (isset($_GET['test'])) {
  send_message(get_current_user_id(), 'successfully-registered', array('username' => get_user_by('ID', get_current_user_id())->display_name));
  header('Location: ' . pll_home_url() . 'message/'); exit;
}
redirect_login(); get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-help-center.jpg) center center / cover no-repeat">
      <div class="container">
        <?php if (current_user_can('judge_works')): ?>
        <h1>_大咖中心 <br>JUDGE CENTER</h1>
        <?php else: ?>
        <h1>_个人中心 <br>USER CENTER</h1>
        <?php endif; ?>
      </div>
    </div>
    <!-- Menu -->
    <div class="container-fluid user-center-menu">
      <div class="container">
        <ul>
          <?php if (current_user_can('judge_works')): ?>
          <li><a href="<?=pll_home_url()?>judge-center/"><?=__('个人信息', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>judge-center/?event"><?=__('我的竞赛', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>judge-center/?activity"><?=__('我的活动', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>judge-center/?like"><?=__('我的收藏', 'young-bird')?></a></li>
          <?php else: ?>
          <li><a href="<?=pll_home_url()?>user-center/"><?=__('个人信息', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>user-center/?event"><?=__('我的竞赛', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>user-center/?activity"><?=__('我的活动', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>user-center/?like"><?=__('我的收藏', 'young-bird')?></a></li>
          <?php endif; ?>
          <li class="active">
            <a href="<?=pll_home_url()?>message/"><?=__('消息', 'young-bird')?>
              <?php if ($has_unread_message = get_user_meta(get_current_user_id(), 'has_unread_message', true)): ?><i></i><?php endif; ?>
            </a>
          </li>
          <?php $user_applyed=get_posts(array(
              'post_type'=>'campus_apply',
              'author'=>get_current_user_id(),
              'meta_key'=>'status',
              'meta_value'=>'pass',
          ));

          if($user_applyed):?>
            <li><a href="<?=pll_home_url()?>user-center/?campus">站长中心 </a></li>
          <?php endif;?>
        </ul>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body">
      <div class="row mx-auto mb-2 justify-content-between">
        <h4><?=__('全部消息：', 'young-bird')?><?=$wp_query->found_posts?></h4>
        <h4><?=__('未读消息：', 'young-bird')?><?=get_user_meta(get_current_user_id(), 'unread_messages', true) ?: 0?></h4>
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
<?php get_footer();

delete_user_meta(get_current_user_id(), 'unread_messages');
delete_user_meta(get_current_user_id(), 'has_unread_message');
