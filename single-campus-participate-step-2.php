<?php
redirect_login();

$id_dl = pll_get_post(get_the_ID(), pll_default_language());
$event=get_post_meta($id_dl,'event',true);


get_header();?>

<div class="container mt-210 pb-7 user-center-body">
    <form method="POST" accept-charset="UTF-8">
        <div class="row d-flex justify-content-between">
            <div class="col-md-12 col-xl-12 p-xs-0 bs_info_container">
                <div class="mx-auto base-info-container">

                    <div class="col-24 p-md-0">
                        <h2><?=__('基本信息', 'young-bird')?></h2>
                    </div>
                    <div class="col-24 p-md-0">
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label><?=__('姓名', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="name" value="<?=$name?>" class="form-control" placeholder="<?=__('姓名', 'young-bird')?>">
                            </div>
                        </div>

                        <div class="form-group  d-flex justify-content-between align-items-center">
                            <label><?=__('手机', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="phone" value="<?=$phone?>" class="form-control" placeholder="<?=__('手机', 'young-bird')?>">
                            </div>
                        </div>


                        <div class="form-group  d-flex justify-content-between align-items-center">
                            <label><?=__('微信', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="wechat_number" value="<?=$wechat_number?>" class="form-control" placeholder="<?=__('微信号', 'young-bird')?>">
                            </div>
                        </div>
                        <?php if (!$user->user_email): ?>
                            <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <input type="email" required name="email" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?>">
                                </div>
                            </div>
                        <?php endif; ?>


                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label><?=__('状态', 'young-bird')?>:</label>
                            <div class="input-group">
                                <select name="identity" required class="form-control custom-select">
                                    <option<?=!$identity ? ' selected' : ''?> disabled></option>
                                    <option<?='studying' === $identity ? ' selected' : ''?> value="studying"><?=__('学生', 'young-bird')?></option>
                                    <option<?='working' === $identity ? ' selected' : ''?> value="working"><?=__('在职', 'young-bird')?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group hide-on-studying d-flex justify-content-between align-items-center">
                            <label><?=__('公司', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" name="company" value="<?=$company?>" class="form-control"placeholder="<?=__('公司', 'young-bird')?>">
                            </div>
                        </div>

                        <div class="form-group hide-on-working d-flex justify-content-between align-items-center">
                            <label><?=__('学校', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="school" value="<?=$school?>" class="form-control" placeholder="<?=__('学校', 'young-bird')?>">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-xl-12 p-xs-0 bs_info_container">
                <div class="mx-auto base-info-container">
                    <div class="col-24 p-md-0 d-flex justify-content-end">
                        <h2><?=__('资料', 'young-bird')?></h2>
                    </div>
                    <div class="col-24 p-md-0">
                        <div class="form-group d-flex justify-content-end align-items-center">
                            <label><?=__('国家', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="country" value="<?=$country?>" class="form-control" placeholder="<?=__('国家', 'young-bird')?>">
                            </div>
                        </div>

                        <div class="form-group  d-flex justify-content-end align-items-center">
                            <label><?=__('城市', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="city" value="<?=$city?>" class="form-control" placeholder="<?=__('城市', 'young-bird')?>">
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-end align-items-center">
                            <label><?=__('具体地址', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" name="address" required="" value="<?=$address?>" class="form-control" placeholder="<?=__('具体地址', 'young-bird')?>"/>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-end align-items-center">
                            <label><?=__('身份证', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="id_card" value="<?=$id_card?>" class="form-control" placeholder="<?=__('身份证', 'young-bird')?>">
                            </div>
                        </div>

                        <div class="form-group hide-on-studying d-flex justify-content-end align-items-center">
                            <label><?=__('银行卡号', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" name="bankcard" value="<?=$bankcard?>" class="form-control" placeholder="<?=__('银行卡号', 'young-bird')?>">
                            </div>
                        </div>

                        <div class="form-group hide-on-working d-flex justify-content-end align-items-center">
                            <label><?=__('开户行', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" name="bank" value="<?=$bank?>" class="form-control" placeholder="<?=__('开户行', 'young-bird')?>">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mx-auto d-flex justify-content-center mt-202 notice_info">
                <div class="col-md-18 ">
                    <p class=" d-flex justify-content-between"><span><?=__('注', 'young-bird')?>：</span><?=__('请填写您的现住地址，我们将根据以上信息向您进行物资的寄送及收入的发放，为保障您能准时收到物资和收入，请务必按实际情况填写完整信息，我们承诺将严格保密您的所有信息！', 'young-bird')?></p>
                </div>
            </div>

            <div class="row mx-auto justify-content-between conform_box">
                <div class="d-flex justify-content-between align-items-end third-party">
                    <a href="<?php echo get_the_permalink();?>" class="btn bnt_nomal btn_back"><?=__('返回', 'young-bird')?></a>
                    <button type="submit" name="participate" value="step-3"  class="btn bnt_nomal btn_next" data-toggle="modal" data-target="#warning_has"><?=__('下一步', 'young-bird')?></button>
         