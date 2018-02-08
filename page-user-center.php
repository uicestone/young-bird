<?php get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-help-center.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_用户中心 <br>USER CENTER</h1>
      </div>
    </div>
    <!-- Menu -->
    <div class="container-fluid user-center-menu">
      <div class="container">
        <ul>
          <li class="active"><a href="/user-center/">个人信息</a></li>
          <li><a href="/event/?user-center">我的比赛</a></li>
          <li><a href="/message/">消息<i></i></a></li>
        </ul>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body">
      <form method="post">
        <div class="row">
          <div class="col-12">
            <div class="row mx-auto info-container">
              <div class="col-6">
                <div class="custom-file-container d-flex justify-content-center align-items-center flex-column">
                  <i class="fas fa-plus"></i>
                  <input type="file" class="custom-file-input">
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
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="role" class="form-control" placeholder="身份">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="school" class="form-control" placeholder="学校">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="constellation" class="form-control" placeholder="星座">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="address" class="form-control" placeholder="地址">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="title" class="form-control" placeholder="部门">
              </div>
            </div>
          </div>
          <div class="col-12">
          <div class="form-group">
            <div class="input-group input-group-lg">
              <input type="text" name="account" class="form-control" placeholder="账号">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group input-group-lg">
              <input type="text" name="email" class="form-control" placeholder="邮箱">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group input-group-lg">
              <input type="text" name="birthday" class="form-control" placeholder="生日">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group input-group-lg">
              <input type="text" name="major" class="form-control" placeholder="专业">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group input-group-lg">
              <input type="text" name="account" class="form-control" placeholder="账号">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group input-group-lg">
              <input type="text" name="company" class="form-control" placeholder="公司">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group input-group-lg">
              <input type="text" title="title" class="form-control" placeholder="职位">
            </div>
          </div>
        </div>
        </div>
        <div class="row mx-auto justify-content-end">
          <button type="submit" class="btn btn-lg btn-secondary btn-common">保存</button>
        </div>
      </form>
    </div>
<?php get_footer(); ?>
