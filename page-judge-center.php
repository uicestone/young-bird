<?php get_header(); ?>
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
      <form method="post">
        <div class="row">
          <div class="col-12">
            <div class="row mx-auto info-container">
              <div class="col-6">
                <div class="custom-file-container d-flex justify-content-center align-items-center flex-column">
                  <i class="fas fa-plus"></i>
                  <input type="file" name="avatar" class="custom-file-input">
                </div>
              </div>
              <div class="col-18">
                <div class="form-group">
                  <div class="input-group input-group-lg">
                    <input type="text" name="name" class="form-control" placeholder="姓名">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-lg">
                    <input type="text" name="mobile" class="form-control" placeholder="手机">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="birthday" class="form-control" placeholder="生日">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="email" class="form-control" placeholder="邮箱">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="role" class="form-control" placeholder="身份">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt d-none"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="companies[]" class="form-control" placeholder="机构">
                <input type="text" name="titles[]" class="form-control" placeholder="部门/头衔">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt d-none"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="awards" class="form-control" placeholder="奖项">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt d-none"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="school" class="form-control" placeholder="毕业院校（选填）">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="major" class="form-control" placeholder="专业（选填）">
              </div>
            </div>
          </div>
        </div>
        <div class="row mx-auto">
          <div class="input-group mb-3">
            <textarea name="bio" class="form-control form-control-lg desc" placeholder="描述"></textarea>
          </div>
          <div class="input-group input-group-lg mb-3">
            <div class="custom-file">
              <!-- En版请使用lang="en" -->
              <input type="file" name="resume" class="custom-file-input" id="resume" lang="zh">
              <label class="custom-file-label" for="resume">点击上传详细简历</label>
            </div>
          </div>
        </div>
        <div class="row mx-auto">
          <button type="submit" class="btn btn-secondary btn-lg btn-common float-right">保存</button>
        </div>
      </form>
    </div>
<?php get_footer(); ?>
