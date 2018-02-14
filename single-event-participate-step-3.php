    <!-- Banner -->
    <!-- for desktop -->
    <div class="container-fluid px-0 d-none d-lg-block">
      <img src="<?=get_field('banner_desktop')['url']?>" width="100%" alt="">
    </div>
    <!-- for pad -->
    <div class="container-fluid px-0 d-none d-md-block d-lg-none">
      <img src="<?=get_field('banner_pad')['url']?>" width="100%" alt="">
    </div>
    <!-- for smart phone -->
    <div class="container-fluid px-0 d-md-none">
      <img src="<?=get_field('banner_phone')['url']?>" width="100%" alt="">
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7">
      <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-start align-items-center logo">
          <img src="<?=get_field('logo')['url']?>" alt="">
        </div>
        <div class="col-md-12 offset-md-2">
          <h1 class="font-weight-bold color-silver text-center mb-4">报名信息填写</h1>
          <h3 class="font-weight-normal color-silver text-center">请选择您的参赛身份</h3>
          <div class="form-participate-position">
            <form method="post">
              <div class="row options mt-6 mb-5">
                <div class="col d-flex justify-content-center align-items-center">
                  <i class="far fa-square"></i>
                  <span class="mx-4">个人参赛</span>
                </div>
                <div class="col d-flex justify-content-center align-items-center">
                  <i class="far fa-square"></i>
                  <span class="mx-4">团队参赛</span>
                </div>
              </div>
              <div class="check-0 d-none">
                <div class="row mx-auto">
                  <a href="<?php get_the_permalink() ?>?create-work" class="btn btn-lg btn-secondary btn-block px-5">上传</a>
                </div>
              </div>
              <div class="check-1 d-none">
                <h4 class="font-weight-normal color-silver my-3">你可以创建一个团队，或者去寻找一个团队加入</h4>
                <div class="row no-gutters mb-4 tab">
                  <div class="col">
                    <button type="button" class="btn btn-lg btn-secondary btn-block">创建</button>
                  </div>
                  <div class="col">
                    <button type="button" class="btn btn-lg btn-secondary btn-block bg-light-grey">加入</button>
                  </div>
                </div>
                <div class="form-group team">
                  <div class="input-group input-group-lg">
                    <input type="text" name="group_name_create" class="form-control" placeholder="团队名称">
                    <div class="input-group-append">
                      <button type="submit" name="create_group" class="btn btn-secondary px-5">创建</button>
                    </div>
                  </div>
                </div>
                <div class="form-group team d-none">
                  <div class="input-group input-group-lg">
                    <input type="text" name="group_name_join" class="form-control" placeholder="团队名称">
                    <div class="input-group-append">
                      <button type="submit" name="join_group" class="btn btn-secondary px-5">加入</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
