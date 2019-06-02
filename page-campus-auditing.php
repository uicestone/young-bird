<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2018/12/20
 * Time: 16:42
 */
/*
Template Name: 审核站长
*/




$current_url = home_url(add_query_arg(array()));
if( !current_user_can( 'manage_options' ) ) {
    return ;
}
$my_post=0;
if(!$_GET['campus_id'])
{
    return '页面未找到';
}

if($_GET){
    $campus=get_post($_GET['campus_id']);
        $user=get_user_by('ID',$campus->post_author);

    if(isset($_GET['pass'])) {

        update_post_meta($_GET['pass'], 'status', 'pass');
     //   add_post_meta(get_current_user_id(), 'campus', $id_dl);
        add_user_meta($user->ID, 'campus_head',$_GET['campus_id']);
        $user->add_role('campus');
        $event=get_post_meta(get_post_meta($_GET['campus_id'],'campus_id',true),'event',true);
        if(get_user_meta($user->ID,'locale',true)=='en_US'){
            $event=get_post(pll_get_post($event,'en_US'))->post_title;
        }
       else{
           $event=get_post(pll_get_post($event,pll_default_language()))->post_title;
       }

       $school='';

        foreach(get_post_meta($campus->ID,'school_id')[0] as $v){

            if(get_user_meta($user->ID,'locale',true)=='en_US')
            {
                $v=pll_get_post($v,'en_US');
            }
            $school.=get_post($v)->post_title.',';

        }



        $school=mb_substr($school,0,mb_strlen($school)-1);
        send_message($campus->post_author, 'congratulations', array('event' => $event,'school'=>$school));;
        header('Location: ' . $_GET['destination']);
    }
    if(isset($_GET['fail'])) {
        //echo get_user_meta($user->ID,'locale',true);

      // update_post_meta($_GET['fail'], 'status', 'failed');
    }




}

if($_POST){
    update_post_meta($_POST['fail'], 'status', 'failed');
    add_post_meta($_POST['fail'], 'reason', $_POST['reason']);

    $event=get_post_meta(get_post_meta($_POST['fail'],'campus_id',true),'event',true);
    if(get_user_meta($user->ID,'locale',true)=='en_US'){
        $event=get_post(pll_get_post($event,'en_US'))->post_title;
    }
    else{
        $event=get_post(pll_get_post($event,pll_default_language()))->post_title;
    }

    send_message($campus->post_author, 'faild_campus', array('reason' => $_POST['reason']));;
    header('Location: ' . $_POST['destination']);
}

/*$campus=$_GET['campus_id'];
$campus=pll_get_post($campus,pll_default_language());
$posts=get_posts(array(
        'post_type'=>'campus_apply',
        'meta_key'=>'campus_id',
        'meta_value'=>$campus
));
$campus=get_post($campus);
$event=get_post_meta($campus->ID,'event',true);

$event=get_post($event);*/

?>




<!-- Banner -->
<!-- for desktop -->
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