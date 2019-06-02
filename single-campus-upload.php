<?php
/**
 * Created by PhpStorm.
 * User: icesw
 * Date: 2018-12-22
 * Time: 23:42
 */


$myapplyschool=get_post_meta($user_applyed[0]->ID,'school_id',true);
get_header();
$image_status=get_post_meta($user_applyed[0]->ID,'picture_exam',true);
if(isset($_POST['submit']))
{
    if($image_status!='pass') {


        if (get_post_meta($user_applyed[0]->ID, 'picture_exam', true)) {
            update_post_meta($user_applyed[0]->ID, 'picture_exam', 'Unaudited');
        } else {
            add_post_meta($user_applyed[0]->ID, 'picture_exam', 'Unaudited');
        }
    }
}
?>

    <div class="container mt-32 mt-lg-7">
        <div class="zz-action-title d-flex flex-column justify-content-start">
            <h2 class=""><?=__('本次负责的竞赛', 'young-bird')?></h2>
            <h1><?php $event=get_post_meta($id_dl,'event',true);echo get_post($event)->post_title;?></h1>
        </div>
    </div>
    <div class="container mt-232 pb-207">
        <div class="row pubu">
            <div class="col-md-24">
                <div class="row pubu-list">

                    <?php foreach($myapplyschool as $v):?>
                    <?php $myschool=get_post(pll_get_post($v,ICL_LANGUAGE_CODE));?>

                            <div class="col-md-12">
                        <div class="card mb-4 item-ZZschool">
                            <h2><?=$myschool->post_title;?></h2>

                            <?php


                            $image_post = get_posts(array(
            'post_type' => 'campusimage',
            'author' => get_current_user_id(),
            'meta_query' => array(
                array('key' => 'campus_id', 'value' =>$id_dl),
                array('key' => 'school_id', 'value' =>$v)

            )));
                            $image_post ;?>

                            <?php if(empty($image_post)):?>

                                <div class="card-body justify-content-between align-items-center">
                                    <p class="mx-auto"><?=__('“暂未开始计算，请先完成任务并上传相应证明图片或文件。”', 'young-bird')?></p>
                                </div>
                            <?php else:?>
                            <div class="card-body justify-content-between align-items-center">
                                <h2><?=__('报名人数', 'young-bird')?> : <span> <?php print get_post_meta($image_post[0]->ID,'campus_register_count',true);?></span></h2>

                                <h2><?=__('作业上交人数', 'young-bird')?> : <span> <?php print get_post_meta($image_post[0]->ID,'campus_work_count',true);?></span></h2>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                    <?php endforeach;?>
                    </div>
                </div>
            </div>

        <div class="row up_load_container">

            <div class="col-24">

                    <h2><?=__('负责的学校', 'young-bird')?></h2>
                    <h4><?=__('( 支持的文件类型为：JPG/PNG,每张图片最小不得小于1M )', 'young-bird')?></h4>
                    <?php foreach($myapplyschool as $v):?>
                    <?php $myschool=get_post(pll_get_post($v,ICL_LANGUAGE_CODE));?>
                    <div class="row action_school">
                        <div class="up_load_box col-md-12 col-xs-18">
                            <h3><?=$myschool->post_title;?></h3>
                            <div class="row up_load_items">
                                <?php  $image_post = get_posts(array(
            'post_type' => 'campusimage',
            'author' => get_current_user_id(),
            'meta_query' => array(
                array('key' => 'campus_id', 'value' => $id_dl),
                array('key' => 'school_id', 'value' => $v)

            )));

                              ?>
                                <?php if(!empty($image_post)):?>

                                   <?php $images=get_post_meta($image_post[0]->ID,'image1');?>
                                    <?php if(!empty($images[0])):?>
                               <?php foreach($images as $img):?>
                                <div class="up_load_item" style="height:150px;">
                                    <img class="img-fluid mx-auto smallimg" src="<?=wp_get_attachment_url($img['ID']);?>">
                                    <?php if($image_status!='pass'):?>
                                    <a class="campus-image-delete" id="f-<?=$img['ID'];?>" data-item-id="<?=$v;?>"> <img src="/img/icon/del.png"></a>
                                    <?php endif;?>
                                </div>
                                <?php endforeach;?>
                                    <?php endif;?>
                                <?php endif;?>
                            </div>

                        </div>
                        <div class="col-md-12 up_btn_box">

<?php if($image_status!='pass'):?>
                            <form id="imageUpload" enctype="multipart/form-data">
                                <input type="file" class="file"  accept="image/jpeg,image/png" id="<?=$v;?>" style="display: none;" />
                                <a class="btn btn_zzUp "><?=__('上传', 'young-bird');?></a>
                            </form>
                            <?php endif;?>
                        </div>
                    </div>
                    <?php endforeach;?>

            </div>

            <div class="col-24">
                <?php if($image_status!='pass'):?>
                <form method="post">
                <input type="submit" name="submit" value="<?=__('提交', 'young-bird');?>"/>
                </form>
                <?php endif;?>

            </div>
        </div>

    </div>
    <div class="container mt-232 pb-207">
        <?php if($zzzm=get_post_meta($id_dl,'campus_handbook',true)):?>

        <div class="row zz_downLoad">
            <h2><?=__('【站长工作手册】', 'young-bird')?></h2>

            <a href="<?php print wp_get_attachment_url($zzzm);?>" download ><?=__('下载', 'young-bird')?></a>
        </div>
        <?php endif;?>
        <?php if($zzzm=get_post_meta($user_applyed[0]->ID,'campus_cert_url',true)):?>
        <div class="row zz_downLoad">
            <h2><?=__('【站长证明】', 'young-bird')?></h2>
            <a href="<?php echo $zzzm;?>"><?=__('下载', 'young-bird')?></a>
            
        </div>
        <?php endif;?>
        <div class="row jianliupload zz_downLoad">
            <?=__('简历', 'young-bird')?></h2>
            <div class="jianli"></div>
            <input type="file" class="file"  id="jianli" style="display: none;" />
            <a class="btn btn_zzUp "><?=__('上传', 'young-bird');?></a>
        </div>
    </div>
    <div class="container mt-32 pb-7 qr-container">
        <?php if($qr_code=get_post_meta($id_dl,'campus_qrcode',true)):?>
        <img class="img-fluid  mx-auto d-block" src="<?php print wp_get_attachment_url($qr_code);?>">
            <?php endif;?>
        <p><?=__('YoungPower微信客服号', 'young-bird')?></p>
    </div>
    <img src="" alt="" class="bigimg">
    <div class="mask">
        <img src="/img/close.png" alt="">
    </div>

<?php get_footer();?>

<?php if(isset($_POST['submit'])):?>


        <div class="modal fade" id="picture_submit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><?=__('您所提交的图片正在审核中，请耐心等待。', 'young-bird');?></p>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(function () {
                $(document).ready(function () {
                    $('#picture_submit').modal();
                });

            });
        </script>


<?php endif;?>


<script>

    $(function () {
        $(document).ready(function () {

            $(function() {
                var obj = new zoom('mask', 'bigimg', 'smallimg');
                obj.init();
            })

            $('.btn_zzUp').click(function(){
                $(this).prev('input').click();
            });
            function customdelete()
            {
                $('.campus-image-delete').click(function () {
                    var campusid =<?=$id_dl;?>;
                    var input = $(this);
                    $.ajax({
                        url: '/ajaxcampus',
                        type: 'POST',
                        dataType: "json", //数据格式:JSON
                        data: '&fid=' + $(this).attr('id') + '&schoolid=' + $(this).attr('data-item-id') + '&campusid=' + campusid + '&type=delete', //这个是上一步，创建的对象


                        success: function (json1) {
                            console.log(json1);
                            if (json1 == 'success') {
                                input.parent().remove();
                            }
                        },
                        error: function (err1, err12) {
                            console.log(err1);
                            console.log(err12);

                        }


                    });
                });
            }
            $('.up_load_container .file').change(function(){
                if(!$(this).val())
                    return;
                var schoolid=$(this).attr('id');
                var input=$(this);
                var campusid=<?=$id_dl;?>;
                var fileObject = $('input#'+schoolid)[0].files[0] // 或者使用原生方法获取文件 document.getElementById("photo").files[0];
                var filename = fileObject.name;

                // 创建一个虚拟的表单，把文件放到这个表单里面
                var imageData = new FormData();
                imageData.append( "file", fileObject);
                var fileid;
                $.ajax({
                    url: '/uploadajax',
                    type: 'POST',
                    data: imageData, //这个是上一步，创建的对象

                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: { 'Content-Disposition': 'attachment;filename=test.jpg' },
                    success: function (json) {
                        json = $(json).html();
                        fileid=json;
                        $.ajax({
                            url: '/ajaxcampus',
                            type: 'POST',
                            dataType: "json", //数据格式:JSON
                            data: '&fid='+fileid+'&schoolid='+schoolid+'&campusid='+campusid+'&type=add', //这个是上一步，创建的对象


                            success: function (json1) {

                                if(json1.status=='success'){
                                    input.val('');
                                    var imglist=input.parents('.action_school').find('.up_load_items').html();
                                    imglist=imglist+' <div class="up_load_item" style="height:150px;"> <img class="img-fluid mx-auto smallimg" src="'+json1.src+'"><a class="campus-image-delete" id="f-'+fileid+'" data-item-id="'+schoolid+'"><img src="/img/icon/del.png"></a></div>'
                                    input.parents('.action_school').find('.up_load_items').html(imglist);
                                    customdelete();

                                    
                                }
                                $(function() {
                                    var obj = new zoom('mask', 'bigimg', 'smallimg');
                                    obj.init();
                                })
                                
                            },
                            error:function(err1,err12){
                                console.log(err1);
                                console.log(err12);

                            }


                        });

                    },
                    error:function(err,err2){
                     console.log(err);
                        console.log(err2);

                    }


                });


            })


            $('.jianliupload .file').change(function(){
                if(!$(this).val())
                    return;

                var input=$(this);

                var fileObject = $(this)[0].files[0] // 或者使用原生方法获取文件 document.getElementById("photo").files[0];
                var filename = fileObject.name;

                // 创建一个虚拟的表单，把文件放到这个表单里面
                var imageData = new FormData();
                imageData.append( "file", fileObject);
                var fileid;
                $.ajax({
                    url: '/uploadresume',
                    type: 'POST',
                    data: imageData, //这个是上一步，创建的对象

                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: { 'Content-Disposition': 'attachment;filename=test.jpg' },
                    success: function (json) {
                        json = $(json).html();
                        fileid=json;
                        console.log(fileid);
                        $.ajax({
                            url: '/ajaxcampus',
                            type: 'POST',
                            dataType: "json", //数据格式:JSON
                            data: '&fid='+fileid+'&resume=true', //这个是上一步，创建的对象


                            success: function (json1) {
                                if(json1.status=='success'){
                                    input.val('');
                                    console.log(json1);
                                    $('.jianli').html('<a href="'+json1.src+'" download>'+json1.filename+'</a>')


                                }
                                $(function() {
                                    var obj = new zoom('mask', 'bigimg', 'smallimg');
                                    obj.init();
                                })

                            },
                            error:function(err1,err12){
                                console.log(err1);
                                console.log(err12);

                            }


                        });

                    },
                    error:function(err,err2){
                        console.log(err);
                        console.log(err2);

                    }


                });


            })
            customdelete()







        });

    });

</script>
