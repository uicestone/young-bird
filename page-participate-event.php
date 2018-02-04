<?php
    get_header();
    if (isset($_GET['step'])) :
      get_template_part('page-participate-event-step-' . $_GET['step']);
    else: ?>
    <!-- Banner -->
    <!-- for desktop -->
    <div class="container-fluid px-0 d-none d-lg-block">
      <img src="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-lg.jpg" width="100%" alt="">
    </div>
    <!-- for pad -->
    <div class="container-fluid px-0 d-none d-md-block d-lg-none">
      <img src="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-md.jpg" width="100%" alt="">
    </div>
    <!-- for smart phone -->
    <div class="container-fluid px-0 d-md-none">
      <img src="<?=get_stylesheet_directory_uri()?>/images/sample/banner-competition-sm.jpg" width="100%" alt="">
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 sign-up">
      <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-start align-items-center logo">
          <img src="<?=get_stylesheet_directory_uri()?>/images/sample/event-logo.png" alt="">
        </div>
        <div class="col-md-12 offset-md-2">
          <h1 class="text-center mb-4">报名信息填写</h1>
          <form>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="姓名">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <select class="form-control custom-select">
                  <option selected disabled="true">状态</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="身份证/护照号码">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="出生日期">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="学校（选填）">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="专业（选填）">
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col">
                  <div class="input-group input-group-lg">
                    <input type="text" class="form-control" placeholder="国家">
                  </div>
                </div>
                <div class="col">
                  <div class="input-group input-group-lg">
                    <input type="text" class="form-control" placeholder="城市">
                  </div>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-lg btn-secondary btn-block">下一步</button>
          </form>
        </div>
      </div>
    </div>
<?php endif;
get_footer();
