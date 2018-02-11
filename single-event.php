<?php
the_post();

$user = wp_get_current_user();

$participate_fields = ['name', 'identity', 'id_card', 'birthday', 'school', 'major', 'country', 'city', 'company', 'department', 'title'];
foreach ($participate_fields as $field) {
  $$field =  get_user_meta($user->ID, $field, true);
}

if (isset($_POST['participate'])) {
  foreach ($participate_fields as $field) {
    if (isset($_POST[$field])) {
      update_user_meta($user->ID, $field, $_POST[$field]);
    }
  }
  header('Location: ' . get_the_permalink() . '?participate=' . $_POST['participate']); exit;
}

get_header();

if (isset($_GET['participate'])):
  $step = $_GET['participate'] ?: 'step-1';
  include(locate_template('single-event-participate-' . $step . '.php'));
else:
?>
    <!-- Body -->
    <div class="container pb-4">
      <div class="sidebar">
        <ul>
          <li>
            <a href="#">竞赛命题</a>
          </li>
          <li>
            <a href="#">奖项设置</a>
          </li>
          <li>
            <a href="#">评委介绍</a>
          </li>
          <li>
            <a href="#">Q&A</a>
          </li>
          <li>
            <a href="#">相关新闻</a>
          </li>
          <li>
            <a href="#">下载文件</a>
          </li>
          <li>
            <a href="<?php the_permalink(); ?>?participate">参赛</a>
          </li>
        </ul>
      </div>
      <div class="content">
        <div class="poster">
          <img src="<?=get_stylesheet_directory_uri()?>/images/sample/event-detail-poster.jpg" alt="">
        </div>
      </div>
    </div>
<?php endif; get_footer(); ?>
