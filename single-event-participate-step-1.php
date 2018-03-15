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
          <form method="post">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" required name="name" value="<?=$name?>" class="form-control" placeholder="<?=__('姓名', 'young-bird')?>">
              </div>
            </div>
            <?php if (!$user->user_email): ?>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="email" required name="email" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?>">
              </div>
            </div>
            <?php endif; ?>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <select name="identity" required class="form-control custom-select">
                  <option<?=!$identity ? ' selected' : ''?> disabled><?=__('状态', 'young-bird')?></option>
                  <option<?='studying' === $identity ? ' selected' : ''?> value="studying"><?=__('学生', 'young-bird')?></option>
                  <option<?='working' === $identity ? ' selected' : ''?> value="working"><?=__('在职', 'young-bird')?></option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" required name="id_card" value="<?=$id_card?>" class="form-control" placeholder="<?=__('身份证', 'young-bird')?>/<?=__('护照号码', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" required name="birthday" value="<?=$birthday?>" class="form-control" placeholder="<?=__('出生日期', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" required name="school" value="<?=$school?>" class="form-control" placeholder="<?=__('学校', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" required name="major" value="<?=$major?>" class="form-control" placeholder="<?=__('专业', 'young-bird')?>">
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col">
                  <div class="input-group input-group-lg">
                    <input type="text" required name="country" value="<?=$country?>" class="form-control" placeholder="<?=__('国家', 'young-bird')?>">
                  </div>
                </div>
                <div class="col">
                  <div class="input-group input-group-lg">
                    <input type="text" required name="city" value="<?=$city?>" class="form-control" placeholder="<?=__('城市', 'young-bird')?>">
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" name="participate" value="step-2" class="btn btn-lg btn-secondary btn-block"><?=__('下一步', 'young-bird')?></button>
          </form>
        </div>
      </div>
    </div>
