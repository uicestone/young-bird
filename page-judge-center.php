<?php get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(images/banner-partners.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_大 咖 <br>PARTNERS</h1>
      </div>
    </div>
    <!-- Menu -->
    <div class="container-fluid user-center-menu">
      <div class="container">
        <ul>
          <li class="active"><a href="">个人信息</a></li>
          <li><a href="">我的比赛</a></li>
          <li><a href="">消息<i></i></a></li>
        </ul>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-5 pb-7 user-center-body judge-sign-in">
      <form action="">
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
                    <input type="text" class="form-control" placeholder="姓名">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-lg">
                    <input type="text" class="form-control" placeholder="手机">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="生日">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="邮箱">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" class="form-control" placeholder="身份">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" class="form-control" placeholder="机构">
                <input type="text" class="form-control" placeholder="部门/头衔">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" class="form-control" placeholder="奖项">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" class="form-control" placeholder="毕业院校（选填）">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" class="form-control" placeholder="专业（选填）">
              </div>
            </div>
          </div>
        </div>
        <div class="row mx-auto">
          <div class="input-group mb-3">
            <textarea class="form-control form-control-lg desc" placeholder="描述"></textarea>
          </div>
          <div class="input-group input-group-lg mb-3">
            <div class="custom-file">
              <!-- En版请使用lang="en" -->
              <input type="file" class="custom-file-input" id="resume" lang="zh">
              <label class="custom-file-label" for="resume">点击上传详细简历</label>
            </div>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button">上传</button>
            </div>
          </div>
        </div>
        <div class="row mx-auto">
          <button type="button" class="btn btn-secondary btn-lg btn-common float-right">保存</button>
        </div>
      </form>
    </div>
    <!-- Footer -->
    <div class="footer">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <ul class="list-inline">
              <li class="list-inline-item mr-4">
                <a href="#">关于我们</a>
              </li>
              <li class="list-inline-item mr-4">
                <a href="#">商务合作</a>
              </li>
              <li class="list-inline-item mr-4">
                <a href="#">帮助中心</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-16">
            <span class="mr-md-4">TELEPHONE & FAX&nbsp;&nbsp;+86 021 6258 5617&nbsp;&nbsp;+86 021 6258 5617-102</span>
            <span class="nowrap">E-MAIL&nbsp;&nbsp;competition@youngbird.com.cn</span>
            <span class="nowrap">沪ICP备 16055号-1|© 2016-2017 Design Verse 版权所有</span>
          </div>
        </div>

      </div>
    </div>

    <script type="text/javascript" src="./bootstrap/js/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="./bootstrap/js/popper.min.js"></script>
    <script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>