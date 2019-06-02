<?php
/**
 * Created by PhpStorm.
 * User: icesw
 * Date: 2018-12-23
 * Time: 0:27
 * Template Name: campus_image
 */


   /* if($user->ID===0)
        return;*/

use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\AbstractFont as Font;
$current_url = home_url(add_query_arg(array()));
if( !current_user_can( 'manage_options' ) ) {
    return ;
}
if(!$_GET['campus_id'])
{
    return '页面未找到';
}

if($_GET){
    $campus=get_post($_GET['campus_id']);
    $user=get_user_by('ID',$campus->post_author);

    if(isset($_GET['pass'])) {

        update_post_meta($_GET['pass'], 'picture_exam', 'pass');
        //   add_post_meta(get_current_user_id(), 'campus', $id_dl);

        $event=get_post_meta(get_post_meta($_GET['campus_id'],'campus_id',true),'event',true);
        if(get_user_meta($user->ID,'locale',true)=='en_US'){
            $event=get_post(pll_get_post($event,'en_US'))->post_title;
        }
        else{
            $event=get_post(pll_get_post($event,pll_default_language()))->post_title;
        }

        $school='';
        $school_en='';
        $school_cn='';
        foreach(get_post_meta($campus->ID,'school_id')[0] as $v){

            $school_cn.=get_post($v)->post_title.',';
            if(get_user_meta($user->ID,'locale',true)=='en_US')
            {
                $v=pll_get_post($v,'en_US');
            }
            $school.=get_post($v)->post_title.',';

            $v=pll_get_post($v,'en_US');
            $school_en.=get_post($v)->post_title.',';

        }
        $school=mb_substr($school,0,mb_strlen($school)-1);
        $school_en=mb_substr($school_en,0,mb_strlen($school_en)-1);
        $school_cn=mb_substr($school_cn,0,mb_strlen($school_cn)-1);


        $username=get_user_meta($user->ID,'name',true);
        $cert_template_participation_path = get_attached_file(102866);
        $filename = 'CERTIFICATE-CAMPUS-1' .$campus->ID.time() . '.jpg';
        $cert_participate = Image::make($cert_template_participation_path);
        $cert_participate->text($username, 280, 1630, function(Font $font) {
            $font->file(FONT_PATH . 'FZSHFW.TTF');
            $font->size(180);
            $font->color('#1D2088');
            $font->align('left');
        })->text(mb_strtoupper($school_en), 280, 2280, function(Font $font) {
            $font->file(FONT_PATH . 'Delicious-SmallCaps.otf');
            $font->size(70);
            $font->color('#1D2088');
            $font->align('left');
        })->text(mb_strtoupper($school_cn), 1040, 2715, function(Font $font) {
            $font->file(FONT_PATH . 'FZSHFW.TTF');
            $font->size(70);
            $font->color('#1D2088');
            $font->align('left');
        })->save(   wp_upload_dir()['path'] .'/'.$filename);

        add_post_meta($campus->ID,'campus_cert_url',wp_upload_dir()['url'] . '/' . $filename);
        send_message($campus->post_author, 'campus_image_pass', array('event' => $event,'school'=>$school));;
        header('Location: ' . $_GET['destination']);
    }
    if(isset($_GET['fail'])) {
        //echo get_user_meta($user->ID,'locale',true);

        //update_post_meta($_GET['fail'], 'picture_exam', 'failed');
    }




}

if($_POST){
    update_post_meta($_POST['fail'], 'picture_exam', 'failed');
    add_post_meta($_POST['fail'], 'reason', $_POST['reason']);

    $event=get_post_meta(get_post_meta($_POST['fail'],'campus_id',true),'event',true);
    if(get_user_meta($user->ID,'locale',true)=='en_US'){
        $event=get_post(pll_get_post($event,'en_US'))->post_title;
    }
    else{
        $event=get_post(pll_get_post($event,pll_default_language()))->post_title;
    }

    send_message($campus->post_author, 'failed_campus_picture', array('reason' => $_POST['reason'],));
    header('Location: ' . $_POST['destination']);

}



?>



<?php
get_header(); ?>
<!-- Banner -->
<div class="container">
    <form method="post" accept-charset="UTF-8">
        <input type="text" size="150" name="reason" placeholder="不通过原因,<?php if(get_user_meta($user->ID,'locale',true)=='en_US') echo '输入英文';else echo '输入中文';?>">
        <input type="hidden" name="campus_id" value="<?php echo $_GET['campus_id'];?>">
        <input type="hidden" name="fail" value="<?php echo $_GET['fail'];?>">
        <input type="hidden" name="uid" value="<?php echo $user->ID;?>">
        <input type="hidden" name="destination" value="<?php echo $_GET['destination'];?>">

        <button type="submit">确定</button>
    </form>
</div>

<?php get_footer(); ?>

<!-- Banner -->
<!-- for desktop -->
