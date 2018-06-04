<?php
redirect_login();
$user = wp_get_current_user();

$sign_up_fields_label = array (
  'mobile' => __('手机', 'young-bird'),
  'identity' => __('身份', 'young-bird'),
  'sex' => __('性别', 'young-bird'),
  'country' => __('国家', 'young-bird'),
  'city' => __('城市', 'young-bird'),
  'school' => __('学校', 'young-bird'),
  'major' => __('专业', 'young-bird'),
  'company' => __('公司', 'young-bird'),
  'department' => __('部门', 'young-bird'),
  'title' => __('职位', 'young-bird'),
  'id_card' => __('身份证号', 'young-bird'),
  'birthday' => __('生日', 'young-bird'),
  'constellation' => __('星座', 'young-bird'),
  'address' => __('地址', 'young-bird'),
  'hobby' => __('爱好', 'young-bird'),
);

$sign_up_fields = array_keys($sign_up_fields_label);

$constellation_first_days = array(
  '01-21' => __('水瓶座', 'young-bird'),
  '02-19' => __('双鱼座', 'young-bird'),
  '03-21' => __('白羊座', 'young-bird'),
  '04-20' => __('金牛座', 'young-bird'),
  '05-21' => __('双子座', 'young-bird'),
  '06-22' => __('巨蟹座', 'young-bird'),
  '07-23' => __('狮子座', 'young-bird'),
  '08-23' => __('处女座', 'young-bird'),
  '09-23' => __('天秤座', 'young-bird'),
  '10-24' => __('天蝎座', 'young-bird'),
  '11-23' => __('射手座', 'young-bird'),
  '12-22' => __('摩羯座', 'young-bird'),
);

$form_values = array();

foreach ($sign_up_fields as $field) {
  $form_values[$field] =  get_user_meta($user->ID, $field, true);
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

  if ($avatar['url']) {
    update_user_meta($user->ID, 'avatar', $avatar['url']);
  }

  if (isset($_FILES['resume']) && array_sum($_FILES['resume']['error']) === 0) {
    $resumes = array_map(function ($file) {
      return wp_handle_upload($file, array ('test_form' => false));
    }, array_collect($_FILES['resume']));
  }

  if (isset($resumes)) {
    $existing_resumes = get_user_meta($user->ID, 'resume');
    foreach ($existing_resumes as $existing_resume) {
      $existing_resume_path_relative = parse_url($existing_resume, PHP_URL_PATH);
      $existing_resume_path = get_home_path() . substr($existing_resume_path_relative, 1);
      unlink($existing_resume_path);
    }
    delete_user_meta($user->ID, 'resume');
    foreach ($resumes as $resume) {
      add_user_meta($user->ID, 'resume', $resume['url']);
    }
  }

  $user = wp_get_current_user();

  if (isset($_GET['recruitment'])) {
    $recruitment_id = $_GET['recruitment'];
    $recruitment_id_dl = pll_get_post($recruitment_id, pll_default_language());

    $message = '<p>' . sprintf(__('您在 Young Bird Plan 的招聘文章《%s》收到了一封简历投递：', 'young-bird'), get_the_title($recruitment_id)) . '</p>';
    $message .= '<ul><li>' . __('姓名', 'young-bird') . "\t" . (get_user_meta($user->ID, 'name', true) ?: $user->display_name) . '</li><li>' . __('邮箱', 'young-bird') . "\t" . $user->user_email . '</li>';

    foreach ($sign_up_fields_label as $field => $label) {
      if ($field_value = get_user_meta($user->ID, $field, true)) {
        $message .= '<li>' . $label . "\t" . $field_value . '</li>';
      }
    }

    $message .= '</ul>';

    if ($resumes = get_user_meta($user->ID, 'resume')) {
      $message .= '<p>' . __('附件：', 'young-bird');
      foreach ($resumes as $resume) {
        $message .= ' <a href="' . $resume . '">' . basename($resume) . '</a> ';
      }
      $message .= '</p>';
    }

    wp_mail(get_field('recruitment_email', $recruitment_id_dl),
      __('简历投递', 'young-bird') . ' - ' . (get_user_meta($user->ID, 'name', true) ?: $user->display_name),
      $message,
      array('Content-Type: text/html; charset=UTF-8', 'Cc: ' . get_option('recruitment_cc_email'))
    );

    add_user_meta($user->ID, 'apply_jobs', $recruitment_id_dl);
    header('Location: ' . get_the_permalink($recruitment_id)); exit;
  }

  elseif (isset($_GET['attend-activity'])) {
    $activity_id = $_GET['attend-activity'];
    $activity_id_dl = pll_get_post($activity_id, pll_default_language());
    add_user_meta($user->ID, 'attend_activities', $activity_id_dl);
    send_message($user->ID, 'successfully-applied-for-this-activity');
    header('Location: ' . get_the_permalink($activity_id)); exit;
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
        <?php elseif (isset($_GET['attend-activity'])): ?>
        <h1>_活动报名 <br>ACTIVITY REGISTER</h1>
        <?php else: ?>
        <h1>_个人中心 <br>USER CENTER</h1>
        <?php endif; ?>
      </div>
    </div>
    <!-- Menu -->
    <?php if (empty($_GET['recruitment']) && empty($_GET['attend-activity'])): ?>
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
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <div class="input-group input-group-lg">
                        <select name="identity" required class="form-control custom-select">
                          <option<?=!$form_values['identity'] ? ' selected' : ''?> disabled><?=__('状态', 'young-bird')?></option>
                          <option<?='studying' === $form_values['identity'] ? ' selected' : ''?> value="studying"><?=__('学生', 'young-bird')?></option>
                          <option<?='working' === $form_values['identity'] ? ' selected' : ''?> value="working"><?=__('在职', 'young-bird')?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group">
                      <div class="input-group input-group-lg">
                        <select name="sex" required class="form-control custom-select">
                          <option<?=!$form_values['sex'] ? ' selected' : ''?> disabled><?=__('性别', 'young-bird')?></option>
                          <option<?='studying' === $form_values['sex'] ? ' selected' : ''?> value="male"><?=__('男', 'young-bird')?></option>
                          <option<?='working' === $form_values['sex'] ? ' selected' : ''?> value="female"><?=__('女', 'young-bird')?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="tel" name="mobile" value="<?=$form_values['mobile']?>" class="form-control" placeholder="<?=$sign_up_fields_label['mobile']?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="email" name="email" value="<?=$user->user_email?>" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?>">
              </div>
            </div>
          </div>
          <div class="form-group col-12 hide-on-working">
            <div class="input-group input-group-lg">
              <input type="text" name="school" value="<?=$form_values['school']?>" class="form-control" placeholder="<?=$sign_up_fields_label['school']?>">
            </div>
          </div>
          <div class="form-group col-12 hide-on-working">
            <div class="input-group input-group-lg">
              <input type="text" name="major" value="<?=$form_values['major']?>" class="form-control" placeholder="<?=$sign_up_fields_label['major']?>">
            </div>
          </div>
          <div class="form-group col-12 hide-on-studying">
            <div class="input-group input-group-lg">
              <input type="text" name="company" value="<?=$form_values['company']?>" class="form-control" placeholder="<?=$sign_up_fields_label['company']?>">
            </div>
          </div>
          <div class="col-12 hide-on-studying">
            <div class="row">
              <div class="form-group col-12">
                <div class="input-group input-group-lg">
                  <input type="text" name="department" value="<?=$form_values['department']?>" class="form-control" placeholder="<?=$sign_up_fields_label['department']?>">
                </div>
              </div>
              <div class="form-group col-12">
                <div class="input-group input-group-lg">
                  <input type="text" name="title" value="<?=$form_values['title']?>" class="form-control" placeholder="<?=$sign_up_fields_label['title']?>">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group col-12">
            <div class="input-group input-group-lg">
              <input type="text" name="id_card" value="<?=$form_values['id_card']?>" class="form-control" placeholder="<?=$sign_up_fields_label['id_card']?>/<?=__('护照号', 'young-bird')?>">
            </div>
          </div>
          <div class="form-group col-12">
            <div class="input-group input-group-lg">
              <input type="text" name="birthday" value="<?=$form_values['birthday']?>" class="form-control datepicker" placeholder="<?=$sign_up_fields_label['birthday']?>" autocomplete="off">
            </div>
          </div>
          <div class="form-group col-12">
            <div class="input-group input-group-lg">
              <input type="text" name="constellation" value="<?=$form_values['constellation']?>" class="form-control" placeholder="<?=$sign_up_fields_label['constellation']?>" data-first-days='<?=json_encode($constellation_first_days, JSON_UNESCAPED_UNICODE)?>'>
            </div>
          </div>
          <div class="form-group col-12">
            <div class="input-group input-group-lg">
              <input type="text" name="hobby" value="<?=$form_values['hobby']?>" class="form-control" placeholder="<?=$sign_up_fields_label['hobby']?>">
            </div>
          </div>
          <div class="col-12">
            <div class="row">
              <div class="form-group col-12">
                <div class="input-group input-group-lg">
                  <input type="text" name="country" value="<?=$form_values['country']?>" class="form-control" placeholder="<?=$sign_up_fields_label['country']?>">
                </div>
              </div>
              <div class="form-group col-12">
                <div class="input-group input-group-lg">
                  <input type="text" name="city" value="<?=$form_values['city']?>" class="form-control" placeholder="<?=$sign_up_fields_label['city']?>" autocomplete="new-address" autofill="off">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group col-12">
            <div class="input-group input-group-lg">
              <input type="text" name="address" value="<?=$form_values['address']?>" class="form-control" placeholder="<?=$sign_up_fields_label['address']?>">
            </div>
          </div>
        </div>
        <?php if (isset($_GET['recruitment'])): ?>
        <div class="row mx-auto">
          <div class="input-group input-group-lg mb-3">
            <div class="custom-file">
              <input type="file" multiple="multiple" name="resume[]" class="custom-file-input" id="resume" lang="<?=pll_current_language()?>" accept=".jpg,.png,.pdf,docx">
              <label class="custom-file-label" for="resume">
                <span class="placeholder"><?=__('点击上传详细简历和作品', 'young-bird')?> <?=__('（支持文件格式为.jpg、.png、.pdf和.docx，总大小不超过20MB）', 'young-bird')?></span>
                <span class="filenames"></span>
              </label>
            </div>
          </div>
          <!-- 显示下载链接 -->
          <?php if ($resumes = get_user_meta($user->ID, 'resume')): ?>
            <div>
              <?php foreach ($resumes as $resume): ?>
              <a class="btn btn-outline-primary" href="<?=$resume?>" target="_blank"><?=basename($resume)?></a>
              <?php endforeach; ?>
            </div>
            <div style="font-weight:lighter;line-height:2.25rem;margin-left:1rem"><?=__('您可以上传新简历和作品，或者使用已有简历和作品直接投递', 'young-bird')?></div>
          <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="row mx-auto justify-content-between">
          <div class="d-flex justify-content-end align-items-end third-party">
            <?php if(!get_user_meta($user->ID, 'wx_unionid', true) && pll_current_language() === 'zh'): ?>
            <div class="d-lg-flex align-items-end d-none">
              <span><?=__('链接到：', 'young-bird')?></span>
              <a href="<?=$wx->generate_web_qr_oauth_url(pll_home_url() . 'user-center/')?>" class="button-share-item button-weixin"></a>
            </div>
            <?php endif; ?>
          </div>
          <?php if (isset($_GET['recruitment'])): ?>
          <button type="submit" name="submit" class="btn btn-lg btn-secondary btn-common"><?=__('投递', 'young-bird')?></button>
          <?php elseif (isset($_GET['attend-activity'])): ?>
          <button type="submit" name="submit" class="btn btn-lg btn-secondary btn-common"><?=__('报名', 'young-bird')?></button>
          <?php else: ?>
          <button type="submit" name="submit" class="btn btn-lg btn-secondary btn-common"><?=__('保存', 'young-bird')?></button>
          <?php endif; ?>
        </div>
      </form>
    </div>
<?php endif; get_footer(); ?>
