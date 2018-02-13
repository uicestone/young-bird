<?php
redirect_login();
$user = wp_get_current_user();

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

get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-partners.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_大 咖 <br>PARTNERS</h1>
      </div>
    </div>
    <!-- Menu -->
    <div class="container-fluid user-center-menu">
      <div class="container">
        <ul>
          <li class="active"><a href="<?=site_url()?>/judge-center/">个人信息</a></li>
          <li><a href="<?=site_url()?>/event/?user-center">我的比赛</a></li>
          <li><a href="<?=site_url()?>/message/">消息<i></i></a></li>
        </ul>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body judge-sign-in">
      <form method="post" enctype="multipart/form-data">
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
                    <input type="text" name="judge_name" value="<?=$user->display_name?>" class="form-control" placeholder="姓名">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-lg">
                    <input type="text" name="mobile" value="<?=$mobile?>" class="form-control" placeholder="手机">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="birthday" value="<?=$birthday?>" class="form-control" placeholder="生日">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="email" value="<?=$user->user_email?>" class="form-control" placeholder="邮箱">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <?php if ($identities): foreach ($identities as $identity): ?>
                <input type="text" name="identities[]" value="<?=$identity?>" class="form-control" placeholder="身份">
                <?php endforeach; else: ?>
                <input type="text" name="identities[]" value="<?=$title?>" class="form-control" placeholder="身份">
                <?php endif; ?>
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt d-none"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <?php if ($titles): foreach ($titles as $title): $institution = explode('/', $title)[0]; $title = explode('/', $title)[1];?>
                <input type="text" name="institutions[]" value="<?=$institution?>" class="form-control" placeholder="机构">
                <input type="text" name="titles[]" value="<?=$title?>" class="form-control" placeholder="部门/头衔">
                <?php endforeach; else: ?>
                <input type="text" name="institutions[]" class="form-control" placeholder="机构">
                <input type="text" name="titles[]" class="form-control" placeholder="部门/头衔">
                <?php endif; ?>
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt d-none"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <?php if ($awards): foreach ($awards as $award): ?>
                <input type="text" name="awards[]" value="<?=$award?>" class="form-control" placeholder="奖项">
                <?php endforeach; else: ?>
                <input type="text" name="awards[]" class="form-control" placeholder="奖项">
                <?php endif; ?>
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt d-none"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="school" value="<?=$school?>" class="form-control" placeholder="毕业院校（选填）">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="major" value="<?=$major?>" class="form-control" placeholder="专业（选填）">
              </div>
            </div>
          </div>
        </div>
        <div class="row mx-auto">
          <div class="input-group mb-3">
            <textarea name="description" class="form-control form-control-lg desc" placeholder="描述"><?=$description?></textarea>
          </div>
          <div class="input-group input-group-lg mb-3">
            <div class="custom-file">
              <!-- En版请使用lang="en" -->
              <input type="file" name="resume" class="custom-file-input" id="resume" lang="zh">
              <label class="custom-file-label" for="resume">点击上传详细简历</label>
              <?php if ($resume = get_user_meta($user->ID, 'resume', true)): ?>
              <!--TODO 显示链接-->
              <a href="<?=$resume?>">查看/下载</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="row mx-auto">
          <button type="submit" name="submit" class="btn btn-secondary btn-lg btn-common float-right">保存</button>
        </div>
      </form>
    </div>
<?php get_footer(); ?>
