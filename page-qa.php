<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2018/12/20
 * Time: 16:42
 */
/*
Template Name: 答疑
*/


get_header();
$user = wp_get_current_user();

$mypost=0;
if(isset($_POST['submit'])){

    $meta=array(
        'name'=>$_POST['faq_name'],
        'mail'=>$_POST['faq_mail'],
        'phone'=>$_POST['faq_phone'],
        'question_type'=>$_POST['question_type'],
        'question'=>$_POST['faq_title'],
        'event_id'=>$_POST['event_id'],
        'customer_publish'=>false

    );
    $array=array(
        'post_title'=>$_POST['faq_title'],
        'author'=>$user->ID,
        'post_type'=>'qaa',
        'post_status'=>'pending',
        'meta_input'=>$meta,

    );

    $mypost=wp_insert_post($array, $wp_error );

    wp_mail($mail,
        __('收到新的题问', 'young-bird') ,
        '收到新的题问',
        array('Content-Type: text/html; charset=UTF-8', 'Cc: ' . 'competition@youngbird.com.cn')
    );
    $files = $_FILES['images'];

    foreach ($files['name'] as $index => $filename) {
        if ($files['name'][$index]) {
            $file = array(
                'name'     => $files['name'][$index],
                'type'     => $files['type'][$index],
                'tmp_name' => $files['tmp_name'][$index],
                'error'    => $files['error'][$index],
                'size'     => $files['size'][$index]
            );
            $wp_upload_dir = wp_upload_dir();



            $basename   = $file['name'];
            $filename   = $wp_upload_dir['path'] . '/' . $basename;
            $re         = rename( $file['tmp_name'], $filename );
            $attachment = array(
                'guid'           => $wp_upload_dir['url'] . '/' . $basename,
                'post_mime_type' => $file['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $basename ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );
            $attach_id  = wp_insert_attachment( $attachment, $filename );
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
            wp_update_attachment_metadata( $attach_id, $attach_data );


            add_post_meta($mypost, 'images', $attach_id);

        }
    }

   /* 'name'=>$_POST['name'],
        'mail'=>$_POST['mail'],
        'phone'=>$_POST['phone'],*/
  /* print_r($_FILES);

    print_r($_POST);*/

}
else{
    if(!$_GET['event_id']){
        return;
    }
    $event_id=$_GET['event_id'];
    $event_id=pll_get_post($_GET['event_id'],pll_current_language());
}


$participate_fields = ['name', 'sex', 'identity', 'id_card', 'birthday', 'school', 'major', 'country', 'city', 'company', 'department', 'title','phone','bankcard','address','bank'];
foreach ($participate_fields as $field) {
    $$field =  get_user_meta(get_current_user_id(), $field, true);
}

$qa=get_posts(array(
        'post_type'=>'qaa',
          'numberposts'     => 5000,
        'meta_query'=>array(
         array('key'=>'customer_publish','value'=>true),
         array('key'=>'event_id',
                'value'=>$event_id)

        ),

));
  ?>


<div class="container">
    <div class="FAQ-container mx-auto">
        <div class="FAQ-innder-container">
            <div class="FAQ_subtit ">
                <h2><?=__('常见问题', 'young-bird')?></h2>
            </div>
            <div class="FAQ_body">
                <?php foreach($qa as $v): ?>
                <?php $current_post=get_post($v->ID);?>
                <?php $id_dl=$v->ID;?>
                    <button class="FAQ_item" data-toggle="collapse" href="#FAQ_<?php print $id_dl;?>" type="button" aria-expanded="false" aria-controls="FAQ_<?php print $id_dl;?>">
                        <p>问</p><h3><span>:</span><?php print $current_post->post_title;?></h3>
                    </button>
                    <div class="collapse" id="FAQ_<?php print $id_dl;?>">
                        <div class="card card-body">
                        <?php print get_post_meta($id_dl,'answer',true);?>
                        </div>
                    </div>
              <?php endforeach;?>
            </div>
        </div>
                <div class="FAQ-innder-container">
                    <div class="FAQ_subtit ">
                        <h2><?=__('提问', 'young-bird')?></h2>
                    </div>
                    <form method="POST" enctype="multipart/form-data" accept-charset="UTF-8">
                        <div class="FAQ_body FAQ_form row">
                            <div class="col-24 p-xs-0">
                                <div class="form-group d-flex justify-content-end align-items-center">
                                    <label><?=__('标题', 'young-bird')?><span>:</span></label>
                                    <div class="input-group">
                                        <input type="text" name="faq_title" value="" class="form-control" placeholder="<?=__('标题', 'young-bird')?>"/>
                                        <input type="hidden" name="event_id" value="<?=$event_id;?>"/>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-end align-items-center">
                                    <label>问题所属类别<span>:</span></label>
                                    <div class="dropdown custom_dropdown">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="ybp_medianotchina" data-toggle="dropdown"aria-haspopup="true" aria-expanded="false"><?=__('问题所属类别', 'young-bird')?></a>
                                        <div class="dropdown-menu" aria-labelledby="ybp_medianotchina">
                                            <div class="dropdown-item">
                                                <input class="form-check-input" type="radio" name="question_type" value="网站使用" id="ybp_FAQsite">
                                                <label class="form-check-label" for="ybp_FAQsite"><?=__('网站使用', 'young-bird')?></label>
                                            </div>
                                            <div class="dropdown-item">
                                                <input class="form-check-input" type="radio" name="question_type" value="竞赛相关" id="ybp_FAQabout">
                                                <label class="form-check-label" for="ybp_FAQabout"><?=__('竞赛相关', 'young-bird')?></label>
                                            </div>
                                            <div class="dropdown-item" href="#">
                                                <input class="form-check-input" type="radio" name="question_type" value="其他问题" id="ybp_FAQother">
                                                <label class="form-check-label" for="ybp_FAQother"><?=__('其他问题', 'young-bird')?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-end align-items-start">
                                    <label>问题正文<span>:</span></label>
                                    <div class="input-group">
                                        <textarea type="text" name="detail" value="" class="form-control" placeholder="<?=__('问题正文', 'young-bird')?>"></textarea>
                                    </div>
                                </div>
                                <div class="FAQ-upload">
                                    <div class="upload-head d-flex justify-content-start align-items-center">
                                        <h5><?=__('相关照片', 'young-bird')?></h5>
                                        <div  class="c-file">
                                            <input type="file" accept="image/jpeg,image/png" name="images[]" data-size-limit="20480" class="custom-file-input">
                                        </div>
                                        <div class="btn btn_Up"><?=__('上传', 'young-bird')?></div>
                                        <p><?=__('( 支持的文件类型为：JPG/PNG,每张图片最小不得小于1M )', 'young-bird')?></p>
                                    </div>
                                    <div class="upload-body">
                                        <div class="row up_load_items">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="FAQ_subtit ">
                                <h2><?=__('留下您的联系方式', 'young-bird')?><br/><?=__('便于我们及时联系您', 'young-bird')?></h2>
                            </div>
                            <div class="FAQ_body FAQ_info">
                                <div class="col-md-24">
                                    <div class="form-group d-flex justify-content-end align-items-center">
                                        <label>姓名<span>:</span></label>
                                        <div class="input-group">
                                            <input type="text" name="faq_name" value="<?=$name;?>" class="form-control" placeholder="<?=__('姓名', 'young-bird')?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end align-items-center">
                                        <label>邮箱<span>:</span></label>
                                        <div class="input-group">
                                            <input type="text" name="faq_mail" value="<?=$user->user_email;?>" class="form-control" placeholder="<?=__('邮箱', 'young-bird')?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-end align-items-center">
                                        <label>手机<span>:</span></label>
                                        <div class="input-group">
                                            <input type="text" name="faq_phone" value="<?=$user->phone;?>" class="form-control" placeholder="<?=__('手机', 'young-bird')?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="FAQ_submit">
                                    <button type="submit"  value="submit" name="submit" class="btn btn-nomal"><?=__('提交', 'young-bird')?></button>
                                </div>


                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
</div>


<?php if($mypost>0):?>
        <div class="modal fade bd-example-modal-lg FAQ_modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <h4><?=__('您的问题我们已收到，我们将尽快通过邮件给您答复，感谢您对我们的关注与支持。', 'young-bird')?></h4>
                    <a type="button" data-dismiss="modal" class="btn btn-nomal"><?=__('确认', 'young-bird')?></a>
                </div>
            </div>
        </div>

    <script>

        $(function () {
            $(document).ready(function () {


                $('.FAQ_modal').modal();





            });

        });

    </script>


<?php endif;?>




<!--<button
    type="button"
    class="btn btn-outline-primary mx-auto mt-lg-7 d-block btn-common mb-4 btn-loadmore "
    data-base-url=""
>



    发现更多
</button>-->


<?php get_footer();?>


<script>

    $(function () {
        $(document).ready(function () {

            $('.btn_Up').click(function(){
                $('.c-file input:last').click();
            });


                    var href=$(".lang-item a").attr("href")+"?event_id=<?php echo $event_id;?>";
                    console.log(href);
                    $(".lang-item a").attr("href",href) ;



            function qa_upload() {

                $('.c-delete').click(function(){
                    var target=$(this).data('target');
                    console.log(target);
                    console.log($('#'+target));
                    $('#'+target).remove();
                    $(this).parent().remove();
                })
                $('input[type=file]').change(function () {
                    var input = this;
                    var _this = $(this);
                    var timestamp = Date.parse(new Date());
                    $(this).attr('id',timestamp);
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {

                            var html = $('.up_load_items').html();
                            html = html + ' <div class="up_load_item col-md-5">  <img class="img-fluid " src="' + e.target.result + '"><a class="c-delete" data-target="'+timestamp+'"><img src="/img/icon/del.png"></a></div>';
                            $('.up_load_items').html(html);
                            $('.c-file').append( '<input type="file" accept="image/jpeg,image/png" name="images[]" data-size-limit="20480" class="custom-file-input">');
                            qa_upload();
                        }
                        reader.readAsDataURL(input.files[0]);

                    }
                })
            }
            qa_upload();

            function settext(){
                $(".FAQ_form .dropdown-item .form-check-label").click(function(){
                    var getText =$(this).text();
                    console.log(getText);
                    var checkChecked = $(this).siblings(".form-check-input");
                    if(checkChecked.is(":checked")){

                    }
                    else{
                        $(this).parents(".custom_dropdown").find(".dropdown-toggle").html(getText);
                    }
                })
            }

            // $('.collapse').collapse()

            settext()





        });

    });

</script>


