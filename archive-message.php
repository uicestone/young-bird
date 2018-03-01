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
          <li><a href="<?=site_url()?>/user-center/"><?=__('个人信息', 'young-bird')?></a></li>
          <li><a href="<?php the_permalink(); ?>?event"><?=__('我的竞赛', 'young-bird')?></a></li>
          <li><a href="<?php the_permalink(); ?>?activity"><?=__('我的活动', 'young-bird')?></a></li>
          <li class="active"><a href="<?=site_url()?>/message/"><?=__('消息', 'young-bird')?><i></i></a></li>
        </ul>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body">
      <div class="row mx-auto mb-2 justify-content-between">
        <h4>全部消息：999</h4>
        <h4>未读消息：999</h4>
      </div>
      <ul class="message-list pl-0">
        <li class="px-5 pt-4 pb-2">
          <h3>团队确认</h3>
          <p>阿娇黑色的复古结合将大幅改善讲啊发给。阿刷空间发噶话说的 阿刷。</p>
        </li>
        <li class="px-5 pt-4 pb-2">
          <h3>团队确认</h3>
          <p>阿娇黑色的复古结合将大幅改善讲啊发给。阿刷空间发噶话说的 阿刷。</p>
        </li>
        <li class="px-5 pt-4 pb-2">
          <h3>团队确认</h3>
          <p>阿娇黑色的复古结合将大幅改善讲啊发给。阿刷空间发噶话说的 阿刷。</p>
        </li>
        <li class="px-5 pt-4 pb-2">
          <h3>团队确认</h3>
          <p>阿娇黑色的复古结合将大幅改善讲啊发给。阿刷空间发噶话说的 阿刷。</p>
        </li>
        <li class="px-5 pt-4 pb-2">
          <h3>团队确认</h3>
          <p>阿娇黑色的复古结合将大幅改善讲啊发给。阿刷空间发噶话说的 阿刷。</p>
        </li>
        <li class="px-5 pt-4 pb-2">
          <h3>团队确认</h3>
          <p>阿娇黑色的复古结合将大幅改善讲啊发给。阿刷空间发噶话说的 阿刷。</p>
        </li>
      </ul>
      <nav class="mt-5">
        <ul class="pagination justify-content-end">
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
              <i class="fas fa-angle-left"></i>
              <span class="sr-only">Previous</span>
            </a>
          </li>
          <li class="page-item active"><a class="page-link" href="#">01</a></li>
          <li class="page-item"><a class="page-link" href="#">02</a></li>
          <li class="page-item"><a class="page-link" href="#">03</a></li>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
              <i class="fas fa-angle-right"></i>
              <span class="sr-only">Next</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
<?php get_footer(); ?>
