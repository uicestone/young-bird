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
    <div class="container mt-32 mt-md-7 pb-48 pb-md-7 sign-up page-participate">
      <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-start align-items-center logo">
          <img src="<?=get_field('logo')['url']?>" alt="">
        </div>
        <div class="col-md-12 offset-md-2">
          <h1 class="font-weight-bold color-silver text-center mb-4"><?=__('报名信息填写', 'young-bird')?></h1>
          <form method="post" accept-charset="UTF-8">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" required name="company" value="<?=$company?>" class="form-control" placeholder="<?=__('公司', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" required name="department" value="<?=$department?>" class="form-control" placeholder="<?=__('部门', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" required name="title" value="<?=$title?>" class="form-control" placeholder="<?=__('职位', 'young-bird')?>">
              </div>
            </div>
            <button type="submit" name="participate" value="step-25" class="btn btn-lg btn-secondary btn-block"><?=__('下一步', 'young-bird')?></button>
          </form>
        </div>
      </div>
    </div>
