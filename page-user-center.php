<?php
redirect_login();
$user = wp_get_current_user();

$sign_up_fields = array ('mobile', 'identity', 'birthday', 'constellation', 'hobby', 'address', 'company', 'department', 'title', 'id_card', 'school', 'major');
$sign_up_fields_label = array (
  'mobile' => __('手机', 'young-bird'),
  'identity' => __('身份', 'young-bird'),
  'birthday' => __('生日', 'young-bird'),
  'constellation' => __('星座', 'young-bird'),
  'hobby' => __('爱好', 'young-bird'),
  'address' => __('地址', 'young-bird'),
  'company' => __('公司', 'young-bird'),
  'department' => __('部门', 'young-bird'),
  'title' => __('职位', 'young-bird'),
  'id_card' => __('身份证号', 'young-bird'),
  'school' => __('学校', 'young-bird'),
  'major' => __('专业', 'young-bird')
);
foreach ($sign_up_fields as $field) {
  $$field =  get_user_meta($user->ID, $field, true);
}

if (isset($_POST['submit'])) {

  foreach ($sign_up_fields as $field) {
    if (isset($_POST[$field])) {
      update_user_meta($user->ID, $field, $_POST[$field]);
    }
  }

  if ($_POST['user_name']) {
    $user->display_name = $_POST['user_name'];
    update_user_meta($user->ID, 'name', $_POST['name']);
  }
  if ($_POST['email']) {
    $user->user_email = $_POST['email'];
  }
  if ($_POST['user_name'] || $_POST['email']) {
    wp_update_user($user);
  }
  if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
  }

  $avatar = wp_handle_upload($_FILES['avatar'], array ('test_form' => false));

  if (isset($_FILES['resume'])) {
    $resume = wp_handle_upload($_FILES['resume'], array ('test_form' => false));
  }

  if ($avatar['url']) {
    update_user_meta($user->ID, 'avatar', $avatar['url']);
  }

  if (isset($resume) && $resume['url']) {
    update_user_meta($user->ID, 'resume', $resume['url']);
  }

  $user = wp_get_current_user();

  if (isset($_GET['recruitment'])) {

    $message = '<p>' . sprintf(__('您在 Young Bird Plan 的招聘文章《%s》收到了一封简历投递：', 'young-bird'), get_the_title($_GET['recruitment'])) . '</p>';
    $message .= '<ul><li>' . __('姓名', 'young-bird') . "\t" . (get_user_meta($user->ID, 'name', true) ?: $user->display_name) . '</li><li>' . __('邮箱', 'young-bird') . "\t" . $user->user_email . '</li>';

    foreach ($sign_up_fields_label as $field => $label) {
      if ($field_value = get_user_meta($user->ID, $field, true)) {
        $message .= '<li>' . $label . "\t" . $field_value . '</li>';
      }
    }

    $message .= '</ul>';

    if ($resume = get_user_meta($user->ID, 'resume', true)) {
      $message .= '<p>' . __('附件：', 'young-bird') . '<a href="' . get_user_meta($user->ID, 'resume', true) . '">' . __('简历下载', 'young-bird') . '</a></p>';
    }

    wp_mail(get_field('recruitment_email', $_GET['recruitment']),
      __('简历投递', 'young-bird') . ' - ' . (get_user_meta($user->ID, 'name', true) ?: $user->display_name),
      $message,
      array('Content-Type: text/html; charset=UTF-8')
    );

    header('Location: ' . get_the_permalink($_GET['recruitment'])); exit;
  }

  header('Location: ' . get_the_permalink()); exit;
}

$wx = new WeixinAPI();

if (isset($_GET['code']) && $oauth_info = $wx->get_oauth_info()) {
  update_user_meta($user->ID, 'wx_unionid', $oauth_info->unionid);
  header('Location: ' . pll_home_url() . 'user-center/'); exit;
}

get_header(); the_post(); if (isset($_GET['event'])):

  include(locate_template('page-user-center-event.php'));

elseif (isset($_GET['activity'])):

  include(locate_template('page-user-center-activity.php'));

elseif (isset($_GET['like'])):

  include(locate_template('page-user-center-like.php'));

else: ?>

    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-help-center.jpg) center center / cover no-repeat">
      <div class="container">
        <?php if (isset($_GET['recruitment'])): ?>
        <h1>_投递简历 <br>JOB APPLICATION</h1>
        <?php else: ?>
        <h1>_用户中心 <br>USER CENTER</h1>
        <?php endif; ?>
      </div>
    </div>
    <!-- Menu -->
    <?php if (empty($_GET['recruitment'])): ?>
    <div class="container-fluid user-center-menu">
      <div class="container">
        <ul>
          <li class="active"><a href="<?php the_permalink(); ?>"><?=__('个人信息', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>user-center/?event"><?=__('我的竞赛', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>user-center/?activity"><?=__('我的活动', 'young-bird')?></a></li>
          <li><a href="<?=pll_home_url()?>user-center/?like"><?=__('我的收藏', 'young-bird')?></a></li>
          <li>
            <a href="<?=pll_home_url()?>message/"><?=__('消息', 'young-bird')?>
              <?php if ($has_unread_message = get_user_meta(get_current_user_id(), 'has_unread_message', true)): ?><i></i><?php endif; ?>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <?php endif; ?>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body">
      <form method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <div class="row">
          <div class="col-12">
            <div class="row mx-auto info-container">
              <div class="col-6">
                <div class="custom-file-container d-flex justify-content-center align-items-center flex-column">
                  <i class="fas fa-plus"></i>
                  <input type="file" name="avatar" class="custom-file-input">
                  <?php if ($avatar = get_user_meta($user->ID, 'avatar', true)): ?>
                  <img src="<?=$avatar?>">
                  <?php else: ?>
                  <img src="" class="d-none">
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-18">
                <div class="form-group">
                  <div class="input-group input-group-lg">
                    <input type="text" name="user_name" value="<?=$user->display_name?>" class="form-control" placeholder="<?=__('姓名', 'young-bird')?>">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-lg">
                    <input type="text" name="mobile" value="<?=$mobile?>" class="form-control" placeholder="<?=$sign_up_fields_label['mobile']?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="identity" value="<?=$identity?>" class="form-control" placeholder="<?=$sign_up_fields_label['identity']?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="school" value="<?=$school?>" class="form-control" placeholder="<?=$sign_up_fields_label['school']?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="constellation" value="<?=$constellation?>" class="form-control" placeholder="<?=$sign_up_fields_label['constellation']?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="address" value="<?=$address?>" class="form-control" placeholder="<?=$sign_up_fields_label['address']?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="department" value="<?=$department?>" class="form-control" placeholder="<?=$sign_up_fields_label['department']?>">
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="id_card" value="<?=$id_card?>" class="form-control" placeholder="<?=$sign_up_fields_label['identity']?>/<?=__('护照号', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="email" value="<?=$user->user_email?>" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="birthday" value="<?=$birthday?>" class="form-control" placeholder="<?=$sign_up_fields_label['birthday']?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="major" value="<?=$major?>" class="form-control" placeholder="<?=$sign_up_fields_label['major']?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="hobby" value="<?=$hobby?>" class="form-control" placeholder="<?=$sign_up_fields_label['hobby']?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="company" value="<?=$company?>" class="form-control" placeholder="<?=$sign_up_fields_label['company']?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" title="title" value="<?=$title?>" class="form-control" placeholder="<?=$sign_up_fields_label['title']?>">
              </div>
            </div>
          </div>
        </div>
        <?php if (isset($_GET['recruitment'])): ?>
        <div class="row mx-auto">
          <div class="input-group input-group-lg mb-3">
            <div class="custom-file">
              <!-- En版请使用lang="en" -->
              <input type="file" name="resume" class="custom-file-input" id="resume" lang="zh">
              <label class="custom-file-label" for="resume"><?=__('点击上传详细简历', 'young-bird')?></label>
            </div>
            <!-- 显示下载链接 -->
            <?php if ($resume = get_user_meta($user->ID, 'resume', true)): ?>
              <div class="input-group-append">
                <a class="btn btn-outline-secondary" href="<?=$resume?>" style="height: 4rem; font-size: 1rem; line-height: 2rem;"><?=__('查看', 'young-bird')?>/<?=__('下载', 'young-bird')?></a>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>
        <div class="row mx-auto justify-content-between">
          <div class="d-flex justify-content-end align-items-end third-party">
            <?php if(!get_user_meta($user->ID, 'wx_unionid', true) && pll_current_language() === 'zh'): ?>
            <div class="d-lg-flex align-items-end d-none">
              <span>链接到：</span>
              <a href="<?=$wx->generate_web_qr_oauth_url(pll_home_url() . 'user-center/')?>" class="button-share-item button-weixin"></a>
            </div>
            <?php endif; ?>
          </div>
          <?php if (isset($_GET['recruitment'])): ?>
          <button type="submit" name="submit" class="btn btn-lg btn-secondary btn-common"><?=__('投递', 'young-bird')?></button>
          <?php else: ?>
          <button type="submit" name="submit" class="btn btn-lg btn-secondary btn-common"><?=__('保存', 'young-bird')?></button>
          <?php endif; ?>
        </div>
      </form>
    </div>
<?php endif; get_footer(); ?>
