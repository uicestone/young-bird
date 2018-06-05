<?php
redirect_login();
$user = wp_get_current_user();
$judge_post = get_posts(array('post_type' => 'judge', 'meta_key' => 'user', 'meta_value' => $user->id))[0];

$sign_up_fields = array ('mobile', 'birthday', 'school', 'major', 'identities', 'titles', 'awards', 'description');
foreach ($sign_up_fields as $field) {
  $$field =  get_user_meta($user->ID, $field, true);
}

if (isset($_POST['submit'])) {

  foreach ($sign_up_fields as $field) {
    if (isset($_POST[$field])) {
      update_user_meta($user->ID, $field, $_POST[$field]);
    }
  }
  if ($_POST['institutions'] && $_POST['titles']) {
    $titles = array_map(function ($institution, $title) {
      return $institution . '/' . $title;
    }, $_POST['institutions'], $_POST['titles']);
    update_user_meta($user->ID, 'titles', $titles);
  }

  if ($_POST['judge_name']) {
    $user->display_name = $_POST['judge_name'];
    update_user_meta($user->ID, 'name', $_POST['name']);
  }
  if ($_POST['email']) {
    $user->user_email = $_POST['email'];
  }
  if ($_POST['judge_name'] || $_POST['email']) {
    wp_update_user($user);
  }
  if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
  }

  $avatar = wp_handle_upload($_FILES['avatar'], array ('test_form' => false));
  $resume = wp_handle_upload($_FILES['resume'], array ('test_form' => false));

  if ($avatar['url']) {
    update_user_meta($user->ID, 'avatar', $avatar['url']);
  }
  if ($resume['url']) {
    update_user_meta($user->ID, 'resume', $resume['url']);
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

else: ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-partners.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_大咖中心 <br>PARTNERS</h1>
      </div>
    </div>
    <!-- Menu -->
    <div class="container-fluid user-center-menu">
      <div class="container">
        <ul>
          <li class="active"><a href="<?=pll_home_url()?>judge-center/"><?=__('个人信息', 'young-bird')?></a></li>
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
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body judge-sign-in">
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
                    <input type="text" name="judge_name" value="<?=$user->display_name?>" class="form-control" placeholder="<?=__('姓名', 'young-bird')?>">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-lg">
                    <input type="text" name="mobile" value="<?=$mobile?>" class="form-control" placeholder="<?=__('手机', 'young-bird')?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="birthday" value="<?=$birthday?>" class="form-control datepicker" placeholder="<?=__('生日', 'young-bird')?>" autocomplete="off">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="email" value="<?=$user->user_email?>" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?>">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <?php if ($identities): foreach ($identities as $index => $identity): ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="identities[]" value="<?=$identity?>" class="form-control" placeholder="<?=__('身份', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <?php if($index === count($identities) - 1): ?>
                <i class="fas fa-plus-circle"></i>
                <?php else: ?>
                <i class="fas fa-minus-circle"></i>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; else: ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="identities[]" value="<?=$title?>" class="form-control" placeholder="<?=__('身份', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle"></i>
              </div>
            </div>
            <?php endif; ?>

            <?php if ($titles): foreach ($titles as $index => $title): $institution = explode('/', $title)[0]; $title = explode('/', $title)[1];?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="institutions[]" value="<?=$institution?>" class="form-control" placeholder="<?=__('机构', 'young-bird')?>">
                <input type="text" name="titles[]" value="<?=$title?>" class="form-control" placeholder="<?=__('部门', 'young-bird')?>/<?=__('头衔', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <?php if($index === count($titles) - 1): ?>
                <i class="fas fa-plus-circle"></i>
                <?php else: ?>
                <i class="fas fa-minus-circle"></i>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; else: ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="institutions[]" class="form-control" placeholder="<?=__('机构', 'young-bird')?>">
                <input type="text" name="titles[]" class="form-control" placeholder="<?=__('部门', 'young-bird')?>/<?=__('头衔', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle"></i>
              </div>
            </div>
            <?php endif; ?>

            <?php if ($awards): foreach ($awards as $index => $award): ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="awards[]" value="<?=$award?>" class="form-control" placeholder="<?=__('奖项', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <?php if($index === count($awards) - 1): ?>
                <i class="fas fa-plus-circle"></i>
                <?php else: ?>
                <i class="fas fa-minus-circle"></i>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; else: ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="awards[]" class="form-control" placeholder="<?=__('奖项', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle"></i>
              </div>
            </div>
            <?php endif; ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="school" value="<?=$school?>" class="form-control" placeholder="<?=__('毕业院校', 'young-bird')?>（<?=__('选填', 'young-bird')?>）">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="major" value="<?=$major?>" class="form-control" placeholder="<?=__('专业', 'young-bird')?>（<?=__('选填', 'young-bird')?>）">
              </div>
            </div>
          </div>
        </div>
        <div class="row mx-auto">
          <div class="input-group mb-3">
            <textarea name="description" class="form-control form-control-lg desc" placeholder="<?=__('描述', 'young-bird')?>"><?=$description?></textarea>
          </div>
          <div class="input-group input-group-lg mb-3">
            <div class="custom-file">
              <!-- En版请使用lang="en" -->
              <input type="file" name="resume" class="custom-file-input" id="resume" lang="zh">
              <label class="custom-file-label" for="resume"><?=__('点击上传详细简历', 'young-bird')?></label>
            </div>
            <!-- 显示下载链接 -->
            <?php if ($resume = get_user_meta($user->ID, 'resume', true)): ?>
            <div class="input-group-append">
              <a class="btn btn-outline-secondary" href="<?=$resume?>" style="height: 4rem; font-size: 1rem; line-height: 2rem;"><?=__('下载', 'young-bird')?></a>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="row mx-auto justify-content-between">
          <div class="d-flex justify-content-end align-items-end third-party">
            <?php if(!get_user_meta($user->ID, 'wx_unionid', true) && pll_current_language() === 'zh'): ?>
            <div class="d-lg-flex align-items-end d-none">
              <span>链接到：</span>
              <a href="<?=$wx->generate_web_qr_oauth_url(pll_home_url() . 'user-center/')?>" class="button-share-item button-weixin"></a>
            </div>
            <?php endif; ?>
          </div>
          <button type="submit" name="submit" class="btn btn-lg btn-secondary btn-common"><?=__('保存', 'young-bird')?></button>
        </div>
      </form>
    </div>
<?php endif; get_footer(); ?>
