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
    <div class="container mt-32 mt-md-7 pb-32 pb-md-7 sign-up page-participate">
      <div class="row align-items-center">
        <div class="col-md-10 d-none d-md-flex justify-content-start align-items-center logo">
          <img src="<?=get_field('logo')['url']?>" alt="">
        </div>
        <div class="col-md-12 offset-md-2">
          <h1 class="font-weight-bold color-silver text-center mb-4"><?=__('报名信息填写', 'young-bird')?></h1>
          <h3 class="font-weight-normal color-silver text-center"><?=__('请选择您的参赛身份', 'young-bird')?></h3>
          <?php if (isset($form_error)): ?>
          <div class="alert alert-danger"><?=$form_error?></div>
          <?php endif; ?>
          <div class="form-participate-position">
            <form method="post" accept-charset="UTF-8">
              <div class="row options mt-4 mt-md-6 mb-4 mb-md-5">
                <div class="col d-flex justify-content-center align-items-center">
                  <i class="far fa-square"></i>
                  <span class="mx-4"><?=__('个人参赛', 'young-bird')?></span>
                </div>
                <div class="col d-flex justify-content-center align-items-center">
                  <i class="far fa-square"></i>
                  <span class="mx-4"><?=__('团队参赛', 'young-bird')?></span>
                </div>
              </div>
              <?php $event_agreement = get_field('event_agreement'); ?>
              <div class="check-0 d-none">
                <div class="form-check my-3">
                  <input class="form-check-input agree-checkbox" type="checkbox" name="agree" value="1" id="agree-single">
                  <label class="form-check-label agree-checkbox-label font-weight-normal color-silver" for="agree-single">
                    <?=sprintf(__('我已阅读并同意此次竞赛的<a href="%s">官方规则</a>', 'young-bird'), get_permalink($event_agreement->ID))?>
                  </label>
                </div>
                <div class="row mx-auto">
                  <a href="<?=get_the_permalink()?>?participate=step-4&single=true" class="btn btn-lg btn-secondary btn-block px-5" onclick="if(!$('agree-single').val()){alert('<?=__('参赛前请先同意官方规则', 'young-bird')?>'); return false}"><?=__('参赛', 'young-bird')?></a>
                </div>
              </div>
              <div class="check-1 d-none">
                <div class="row no-gutters mb-3 mb-md-4 tab">
                  <div class="col">
                    <button type="button" class="btn btn-lg btn-secondary btn-block"><?=__('创建', 'young-bird')?></button>
                  </div>
                  <div class="col">
                    <button type="button" class="btn btn-lg btn-secondary btn-block bg-light-grey"><?=__('加入', 'young-bird')?></button>
                  </div>
                </div>
                <h4 class="font-weight-normal color-silver my-3"><?=__('请先选择“创建”或“加入”团队', 'young-bird')?></h4>
                <div class="form-group team">
                  <div class="input-group input-group-lg">
                    <input type="text" name="group_name_create" class="form-control" placeholder="<?=__('团队名称', 'young-bird')?>" required>
                  </div>
                  <div class="form-check my-3">
                    <input class="form-check-input agree-checkbox" type="checkbox" name="agree" value="1" id="agree-create-group" required>
                    <label class="form-check-label agree-checkbox-label font-weight-normal color-silver" for="agree-create-group">
                      <?=sprintf(__('我已阅读并同意此次竞赛的<a href="%s">官方规则</a>', 'young-bird'), get_permalink($event_agreement->ID))?>
                    </label>
                  </div>
                  <button type="submit" name="create_group" class="mt-2 btn btn-lg btn-secondary btn-block px-5"><?=__('创建', 'young-bird')?></button>
                </div>
                <div class="form-group team d-none">
                  <div class="input-group input-group-lg">
                    <input disabled type="text" name="group_name_join" class="form-control" placeholder="<?=__('团队名称', 'young-bird')?>" required>
                  </div>
                  <div class="form-check my-3">
                    <input disabled class="form-check-input agree-checkbox" type="checkbox" name="agree" value="1" id="agree-join-group" required>
                    <label class="form-check-label agree-checkbox-label font-weight-normal color-silver" for="agree-join-group">
                      <?=sprintf(__('我已阅读并同意此次竞赛的<a href="%s">官方规则</a>', 'young-bird'), get_permalink($event_agreement->ID))?>
                    </label>
                  </div>
                  <button disabled type="submit" name="join_group" class="mt-2 btn btn-lg btn-secondary btn-block px-5"><?=__('加入', 'young-bird')?></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
