<?php
redirect_login();

$id_dl = pll_get_post(get_the_ID(), pll_default_language());
$event=get_post_meta($id_dl,'event',true);

$schools=get_posts(array(
    'post_type'=>'campus_school',
    //'meta_key'
));
$schools=get_post_meta(get_the_ID(),'school',true);

$cityarray=array();
$schoolsarray=array();
foreach($schools as $v)
{
    $school_city=get_post_meta($v,'city',true);

    $cityarray[$school_city]=1;

    if($school_city==$city){
        $schoolsarray[]=$v;
    }
}
get_header();?>

<div class="container mt-210 pb-7 user-center-body">
    <form  method="POST" accept-charset="UTF-8">
        <div class="row d-flex justify-content-center flex-column ch_info_container">

            <div class="col-md-18 mx-auto col-xl-15 p-xs-0 ">
                <div class="row mx-auto choose-info-container">
                    <div class="col-24 p-md-0">
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label>希望管辖的城市:</label>
                            <div class="input-group">
                                <select type="text"   class="school-city form-control">
                                        <?php foreach($cityarray as $k=>$v):?>
                                            <option value="<?php echo $k;?>" <?php if($k==$city) echo 'selected';?>><?php echo $k;?></option>
                                        <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group  d-flex justify-content-between align-items-center">
                            <label>希望管辖的学校:</label>
                            <div class="input-group">
                                <?php if(!isset($_SESSION['new_apply'][$id_dl])):?>
                                <select name="apply_school[]"  data-placeholder="选择学校" id="select-shcool" multiple="multiple" required class="form-control custom-select">
                                    <?php foreach($schoolsarray as $v):?>
                                        <?php $schooltitle=get_post(pll_get_post($v, ICL_LANGUAGE_CODE))->post_title;?>
                                        <option value="<?=$v?>"><?=$schooltitle;?></option>
                                    <?php endforeach;?>
                                </select>
                                <?php else:?>
                                    <?php $sessionschool=$_SESSION['new_apply'][$id_dl]['meta_input']['school_id'];?>
                                    <select name="apply_school[]"  data-placeholder="选择学校" id="select-shcool" multiple="multiple" required class="form-control custom-select">
                                        <?php foreach($schoolsarray as $v):?>
                                        <?php $schooltitle=get_post(pll_get_post($v, ICL_LANGUAGE_CODE))->post_title;?>
                                            <option value="<?=pll_get_post($v, pll_default_language())?>"  <?php if(in_array(pll_get_post($v, pll_default_language()),$sessionschool)) echo ' selected = "selected"';?>><?=$schooltitle;?></option>
                                        <?php endforeach;?>
                                    </select>
                                <?php endif;?>
                            </div>
                        </div>
                        <!-- <div class="form-group d-flex justify-content-between align-items-center">
                            <label></label>
                            <div class="input-group">
                                <div class="is_choosen d-flex justify-content-start align-items-center">

                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="row mx-auto d-flex justify-content-center mt-202 notice_info">
                <div class="col-md-24 ">

                </div>
            </div>
            <div class="row mx-auto justify-content-between conform_box">
                <div class="d-flex justify-content-between align-items-end third-party">
                    <a href="<?php echo get_the_permalink();?>?participate=step-2" class="btn bnt_nomal btn_back"><?=__('返回', 'young-bird')?></a>
                    <button type="submit"  name="participate" value="step-5" class="btn bnt_nomal btn_conform"><?=__('申请', 'young-bird')?></button>
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
        $('.school-city').chosen();
        $('.school-city').change(function() {
            $.ajax({
                url: '<?php echo get_the_permalink(get_the_ID());?>',
                type: 'POST',
                dataType: "json", //数据格式:JSON
                data: '&city=' + $(this).val() + '&change-school=1', //这个是上一步，创建的对象


                success: function (json1) {
                    $('#select-shcool').empty();
                    console.log(json1);
                    $.each(json1,function(val,index){

                        $('#select-shcool').append("<option value='"+index.pllID+"'>"+index.post_title+"</option>");
                        console.log(index.post_title);
                    })
                    $('#select-shcool').chosen("destroy");
                    $('#select-shcool').chosen();
                    //    $('#select-shcool').chosen();


                },
                error: function (err1, err12) {
                    console.log(err1);
                    console.log(err12);

                }
            })});

       // $('#select-shcool').chosen({allow_single_deselect: true,disable_search: false});
    });
</script>
