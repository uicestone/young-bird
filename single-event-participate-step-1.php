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
    <div class="container mt-7 pb-7 sign-up">
      <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-start align-items-center logo">
          <img src="<?=get_field('logo')['url']?>" alt="">
        </div>
        <div class="col-md-12 offset-md-2">
          <h1 class="text-center mb-4">报名信息填写</h1>
          <form method="post">
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="name" value="<?=$name?>" class="form-control" placeholder="姓名">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <select name="identity" class="form-control custom-select">
                  <option<?=!$identity ? ' selected' : ''?> disabled>状态</option>
                  <option<?='studying' === $identity ? ' selected' : ''?> value="studying">学生</option>
                  <option<?='working' === $identity ? ' selected' : ''?> value="working">在职</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="id_card" value="<?=$id_card?>" class="form-control" placeholder="身份证/护照号码">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="birthday" value="<?=$birthday?>" class="form-control" placeholder="出生日期">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="school" value="<?=$school?>" class="form-control" placeholder="学校（选填）">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input type="text" name="major" value="<?=$major?>" class="form-control" placeholder="专业（选填）">
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col">
                  <div class="input-group input-group-lg">
                    <input type="text" name="country" value="<?=$country?>" class="form-control" placeholder="国家">
                  </div>
                </div>
                <div class="col">
                  <div class="input-group input-group-lg">
                    <input type="text" name="city" value="<?=$city?>" class="form-control" placeholder="城市">
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" name="participate" value="step-2" class="btn btn-lg btn-secondary btn-block">下一步</button>
          </form>
        </div>
      </div>
    </div>
