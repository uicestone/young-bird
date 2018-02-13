    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-partners.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_大 咖 <br>PARTNERS</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 judge-sign-in">
      <div class="row align-items-center">
        <div class="col-md-12">
          <p class="mb-4"><strong>请填写下列信息来激活您的账号</strong></p>
          <form method="post">
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <?php foreach ($identities as $identity): ?>
                <input type="text" name="identities[]" value="<?=$identity?>" class="form-control" placeholder="身份">
                <?php endforeach; ?>
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt d-none"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <?php foreach ($titles as $title): $institution = explode('/', $title)[0]; $title = explode('/', $title)[1] ?>
                <input type="text" name="institutions[]" value="<?=$institution?>" class="form-control" placeholder="机构">
                <input type="text" name="titles[]" value="<?=$title?>" class="form-control" placeholder="部门/头衔">
                <?php endforeach; ?>
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt d-none"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <?php foreach ($awards as $award): ?>
                <input type="text" name="awards[]" value="<?=$award?>" class="form-control" placeholder="曾获奖项">
                <?php endforeach; ?>
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle mr-2"></i>
                <i class="fas fa-trash-alt d-none"></i>
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="school" value="<?=$school?>" class="form-control" placeholder="毕业院校（选填）">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="major" value="<?=$major?>" class="form-control" placeholder="专业（选填）">
              </div>
            </div>
            <div class="row">
              <div class="col-md-20">
                <button type="submit" name="sign_up_step" value="3" class="btn btn-secondary btn-block btn-lg">下一步</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
