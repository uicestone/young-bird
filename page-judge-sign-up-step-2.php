    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-partners.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_大 咖 <br>JUDGE CENTER</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-7 judge-sign-in">
      <div class="row align-items-center">
        <div class="col-md-12">
          <p class="mb-4"><strong><?=__('请填写下列信息来激活您的账号', 'young-bird')?></strong></p>
          <form method="post" accept-charset="UTF-8">
            <?php if ($identities): foreach ($identities as $index => $identity): ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="identities[]" value="<?=$identity?>" class="form-control" placeholder="<?=__('身份', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <?php if($index === count($identities) - 1): ?>
                  <i class="fas fa-plus-circle"></i>
                <?php else: ?>
                  <i class="fas fa-minus-circle"></i>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; else: ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="identities[]" value="<?=$title?>" class="form-control" placeholder="<?=__('身份', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle"></i>
              </div>
            </div>
            <?php endif; ?>

            <?php if ($titles): foreach ($titles as $index => $title): $institution = explode('/', $title)[0]; $title = explode('/', $title)[1];?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="institutions[]" value="<?=$institution?>" class="form-control" placeholder="<?=__('机构', 'young-bird')?>">
                <input type="text" name="titles[]" value="<?=$title?>" class="form-control" placeholder="<?=__('部门', 'young-bird')?>/<?=__('头衔', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <?php if($index === count($titles) - 1): ?>
                  <i class="fas fa-plus-circle"></i>
                <?php else: ?>
                  <i class="fas fa-minus-circle"></i>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; else: ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="institutions[]" class="form-control" placeholder="<?=__('机构', 'young-bird')?>">
                <input type="text" name="titles[]" class="form-control" placeholder="<?=__('部门', 'young-bird')?>/<?=__('头衔', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle"></i>
              </div>
            </div>
            <?php endif; ?>

            <?php if ($awards): foreach ($awards as $index => $award): ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="awards[]" value="<?=$award?>" class="form-control" placeholder="<?=__('奖项', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <?php if($index === count($awards) - 1): ?>
                  <i class="fas fa-plus-circle"></i>
                <?php else: ?>
                  <i class="fas fa-minus-circle"></i>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; else: ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="awards[]" class="form-control" placeholder="<?=__('奖项', 'young-bird')?>">
              </div>
              <div class="col-md-4">
                <i class="fas fa-plus-circle"></i>
              </div>
            </div>
            <?php endif; ?>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="school" value="<?=$school?>" class="form-control" placeholder="<?=__('毕业院校', 'young-bird')?>（<?=__('选填', 'young-bird')?>）">
              </div>
            </div>
            <div class="form-group row align-items-center">
              <div class="input-group input-group-lg col-md-20">
                <input type="text" name="major" value="<?=$major?>" class="form-control" placeholder="<?=__('专业', 'young-bird')?>（<?=__('选填', 'young-bird')?>）">
              </div>
            </div>
            <div class="row">
              <div class="col-md-20">
                <button type="submit" name="sign_up_step" value="3" class="btn btn-secondary btn-block btn-lg"><?=__('下一步', 'young-bird')?></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
