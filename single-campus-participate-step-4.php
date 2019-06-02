<?php
redirect_login();

$id_dl = pll_get_post(get_the_ID(), pll_default_language());
$event=get_post_meta($id_dl,'event',true);

$schools=get_posts(array(
    'post_type'=>'campus_school',


));
get_header();?>

<div class="container mt-210 pb-7 user-center-body">
    <form  method="POST" accept-charset="UTF-8">
        <div class="row d-flex justify-content-center flex-column ch_info_container">

            <div class="col-md-18 mx-auto col-xl-11 p-xs-0 ">
                <div class="row mx-auto choose-info-container">
                    <div class="col-24">
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label>希望管辖的城市:</label>
                            <div class="input-group">
                                <input type="text" disabled="disabled"  value="<?=$city?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group  d-flex justify-content-between align-items-center">
                            <label>希望管辖的学校:</label>
                            <div class="input-group">
                                <?php if(!isset($_SESSION['new_apply'][$id_dl])):?>
                                    <select name="apply_school[]"  data-placeholder="选择学校" disabled id="select-shcool" multiple="multiple" required class="form-control custom-select">
                                        <?php foreach($schools as $v):?>
                                            <?php $schooltitle=get_post(pll_get_post($v->ID, ICL_LANGUAGE_CODE))->post_title;?>
                                            <option value="<?=$v->ID?>"><?=$schooltitle;?></option>
                                        <?php endforeach;?>
                                    </select>
                                <?php else:?>
                                    <?php $sessionschool=$_SESSION['new_apply'][$id_dl]['meta_input']['school_id'];?>
                                    <select name="apply_school[]"  data-placeholder="选择学校"  disabled id="select-shcool" multiple="multiple" required class="form-control custom-select">
                                        <?php foreach($schools as $v):?>
                                            <?php $schooltitle=get_post(pll_get_post($v->ID, ICL_LANGUAGE_CODE))->post_title;?>
                                            <option value="<?=pll_get_post($v->ID, pll_default_language())?>"  <?php if(in_array(pll_get_post($v->ID, pll_default_language()),$sessionschool)) echo ' selected = "selected"';?>><?=$schooltitle;?></option>
                                        <?php endforeach;?>
                                    </select>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label></label>
                            <div class="input-group">
                                <div class="is_choosen d-flex justify-content-start align-items-center">
                                    <?php ?>
                                    <?php foreach($sessionschool as $v):?>
                                        <?php $schooltitle=get_post(pll_get_post($v, ICL_LANGUAGE_CODE))->post_title;?>
                                            <h3><?=$schooltitle?></h3>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mx-auto d-flex justify-content-center mt-202 notice_info">
                <div class="col-md-24 ">

                </div>
            </div>





            <div class="row mx-auto justify-content-between conform_box">
                <div class="d-flex justify-content-between align-items-end third-party">
                    <a href="#" class="btn bnt_nomal btn_back"><?=__('返回', 'young-bird')?></a>
                    <button type="submit"  name="participate" value="step-4" class="btn bnt_nomal btn_conform"><?=__('申请', 'young-bird')?></button>
                </div>
            </div>
        </div>
    </form>
</div>



<?php get_footer(); ?>

<?php if(isset($_SESSION['applyed_school'])):?>
<div class="modal fade" id="warning_has" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?=$_SESSION['applyed_school'];?></p>
            </div>
        </div>
    </div>
</div>

<?php unset($_SESSION['applyed_school']);?>

    <script>
        $(function () {
            $(document).ready(function () {
                $('#warning_has').modal();
            });

        });
    </script>
<?php endif;?>


<script>
    $(function () {
        $('#select-shcool').chosen();
        $('#select-shcool').chosen({allow_single_deselect: true});
    });
</script>

<?php if(isset($_SESSION['new_apply'][$id_dl]['post_id'])):?>
    <div class="modal fade" id="success_hasBack" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                    <p><?=__('您的站长申请已经成功提交，在三个工作日内会有我们的工作人员对您的申请进行审核。审核结果将以本站站内信的形式推送给您。请注意查收。', 'young-bird')?></p>
                    <div class="modal_box">
                        <a href="<?=pll_home_url();?>" class="btn bnt_nomal btn_back"><?=__('返回首页', 'young-bird')?></a>
                        <a href="<?=pll_home_url();?>/user-center/" class="btn bnt_nomal btn_next"><?=__('个人中心', 'young-bird')?></a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $(document).ready(function () {
                $('#success_hasBack').modal();
            });

        });
    </script>
<?php endif;?>