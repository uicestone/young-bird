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
          <form method="post">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="company" class="form-control" placeholder="公司">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="department" class="form-control" placeholder="部门">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="title" class="form-control" placeholder="职位">
              </div>
            </div>
            <button type="submit" class="btn btn-lg btn-secondary btn-block">下一步</button>
          </form>
        </div>
      </div>
    </div>
