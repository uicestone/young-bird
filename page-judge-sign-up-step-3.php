    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-partners.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_大 咖 <br>PARTNERS</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 judge-sign-in">
      <p class="mb-4"><strong>请填写下列信息来激活您的账号</strong></p>
      <form method="post" enctype="multipart/form-data" class="row step-3">
        <div class="col-md-6 mb-3">
          <div class="avatar border bg-light-grey d-flex justify-content-center align-items-center flex-column">
            <i class="fas fa-plus"></i>
            <p class="mt-3">请上传您的公关照</p>
            <input type="file" name="avatar" class="custom-file-input">
          </div>
        </div>
        <div class="col-md-18">
          <div class="input-group mb-3">
            <textarea class="form-control" name="bio" placeholder="描述"></textarea>
          </div>
          <div class="input-group input-group-lg mb-3">
            <div class="custom-file">
              <!-- En版请使用lang="en" -->
              <input type="file" name="resume" class="custom-file-input" id="resume" lang="zh">
              <label class="custom-file-label" for="resume">点击上传详细简历</label>
            </div>
          </div>
          <button type="submit" name="sign_up_success" class="btn btn-secondary btn-lg btn-common float-right">保存</button>
        </div>
      </form>
    </div>
