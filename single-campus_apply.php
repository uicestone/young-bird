<?php
/**
 * Created by PhpStorm.
 * User: icesw
 * Date: 2018-12-25
 * Time: 17:19
 */




$id_dl = get_the_ID();
$campus_apply=get_post($id_dl);
$id_dl = get_the_ID();
$apply=get_post($id_dl);


if (isset($_GET['download']) && current_user_can('edit_user'))
{
    $zip = new ZipArchive();
    $filename = wp_upload_dir()['path'] . '/campus-' . get_the_ID() . '.zip';

    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit("cannot open <$filename>\n");
    }

    $campus_id=get_post_meta($id_dl,'campus_id',true);

    $posts=get_posts(
        array('post_type'=>'campusimage',
            'author'=>$apply->post_author,
            'meta_key'=>'campus_id',
            'meta_value'=>$campus_id));

    foreach ($posts as $post) {

        $images=get_post_meta($post->ID,'image1');
        // print_r($images);
        foreach($images as $image){


            $src= $image['guid'];
            /*$src=str_replace('https://www.youngbirdplan.com.cn/','/var/www/ybp/',$src);
            $imagesrc=substr($src,0,strrpos($src,'/'));


            $imagename=substr($src,strrpos($src,'/')+1);


           $zip->addFile($src);*/

            $path = parse_url($src, PHP_URL_PATH);


            $image_filename = basename($src);


            $zip->addFile('/var/www/ybp/' . substr($path, 1), '/' . $image_filename);

        }

    }

    $zip->close();
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="YBcampus-' . $id_dl .'.zip"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($filename);
    unlink($filename);
    exit;

}
$status=0;
$participate_fields = ['wechat_number','name', 'sex', 'identity', 'id_card', 'birthday', 'wechat','school', 'major', 'country', 'city', 'company', 'department', 'title','phone','bankcard','address','bank'];
foreach ($participate_fields as $field) {
    $$field =  get_user_meta($campus_apply->post_author, $field, true);
}
$sessionschool=get_post_meta($id_dl,'school_id',true);
$schoolcity=get_post_meta($sessionschool[0],'city',true);
$user_applyed=get_posts(array(
    'post_type'=>'campus_apply',
    'author'=>$campus_apply->post_author,
    'meta_key'=>'campus_id',
    'meta_value'=>get_post_meta($id_dl,'campus_id',true),
));


if($user_applyed)
    $status=get_post_meta($user_applyed[0]->ID,'status',true);

$user=get_user_by('ID',$campus_apply->post_author);

get_header();?>



<div class="container mt-210 pb-7 user-center-body">
    <form method="POST" accept-charset="UTF-8">
        <div class="row d-flex justify-content-between">
            <div class="col-md-12 col-xl-11 p-xs-0 bs_info_container">
                <div class="row mx-auto base-info-container">

                    <div class="col-22 p-xs-0">
                        <h2>基本信息</h2>
                    </div>
                    <div class="col-22 p-xs-0">
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label><?=__('姓名', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="name" value="<?=$name?>" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="form-group  d-flex justify-content-between align-items-center">
                            <label><?=__('手机', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="phone" value="<?=$phone?>" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="form-group  d-flex justify-content-between align-items-center">
                            <label><?=__('微信', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="wechat_number" value="<?=$wechat_number?>" class="form-control" placeholder="<?=__('微信号', 'young-bird')?>">
                            </div>
                        </div>
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <label><?=__('邮箱', 'young-bird')?>:</label>
                                <div class="input-group">
                                    <input type="email" required name="email" class="form-control" placeholder="" value="<?=$user->user_email;?>">
                                </div>
                            </div>



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
                            <label>公司:</label>
                            <div class="input-group">
                                <input type="text" name="company" value="<?=$company?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group hide-on-working d-flex justify-content-between align-items-center">
                            <label><?=__('学校', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="school" value="<?=$school?>" class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-xl-11 p-xs-0 bs_info_container">
                <div class="row mx-auto base-info-container">
                    <div class="col-22">
                        <h2>资料</h2>
                    </div>
                    <div class="col-22">
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label><?=__('国家', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="country" value="<?=$country?>" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="form-group  d-flex justify-content-between align-items-center">
                            <label><?=__('城市', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="city" value="<?=$city?>" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label>具体地址:</label>
                            <div class="input-group">
                                <input type="text" name="address" required="" value="<?=$address?>" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label><?=__('身份证', 'young-bird')?>:</label>
                            <div class="input-group">
                                <input type="text" required name="id_card" value="<?=$id_card?>" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="form-group hide-on-studying d-flex justify-content-between align-items-center">
                            <label>银行卡号:</label>
                            <div class="input-group">
                                <input type="text" name="bankcard" value="<?=$bankcard?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group hide-on-working d-flex justify-content-between align-items-center">
                            <label>开户行:</label>
                            <div class="input-group">
                                <input type="text" name="bank" value="<?=$bank?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>


<div class="container mt-210 pb-7 user-center-body">
    <form  method="POST" accept-charset="UTF-8">
        <div class="row d-flex justify-content-center flex-column ch_info_container">

            <div class="col-md-18 mx-auto col-xl-11 p-xs-0 ">
                <div class="row mx-auto choose-info-container">
                    <div class="col-24">
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label>希望管辖的城市:</label>
                            <div class="input-group">
                                <input type="text" disabled="disabled"  value="<?=$schoolcity?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group  d-flex justify-content-between align-items-center">
                            <label>希望管辖的学校:</label>
                            <div class="input-group">
                                <?php foreach($sessionschool as $v):?>
                                    <?php print get_post(pll_get_post($v, ICL_LANGUAGE_CODE))->post_title.' ';?>

                                <?php endforeach;?>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label></label>
                            <div class="input-group">
                                <div class="is_choosen d-flex justify-content-start align-items-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>







        </div>
    </form>
</div>


<?php if($status=='pass'):?>

<?php $myapplyschool=get_post_meta($user_applyed[0]->ID,'school_id',true);?>

    <div class="container mt-32 mt-lg-7">
        <div class="zz-action-title d-flex flex-column justify-content-start">
            <h2 class=""><?=__('本次负责的竞赛', 'young-bird')?></h2>
            <h1><?php $event=get_post_meta($user_applyed[0]->ID,'campus_id',true);echo get_post($event)->post_title;?>
          </h1>
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
                                    'author' => $user->ID,
                                    'meta_query' => array(
                                        array('key' => 'campus_id', 'value' =>$event),
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
                                    'author' => $user->ID,
                                    'meta_query' => array(
                                        array('key' => 'campus_id', 'value' => $event),
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

                            <?php endif;?>
                        </div>
                    </div>
                <?php endforeach;?>

            </div>

            <div class="col-24">
                <?php if($image_status!='pass'):?>

                <?php endif;?>

            </div>
        </div>

    </div>
<?php endif;?>
<img src="" alt="" class="bigimg">
    <div class="mask">
        <img src="/img/close.png" alt="">
    </div>
<?php get_footer(); ?>
