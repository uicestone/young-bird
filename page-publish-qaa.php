<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2018/12/20
 * Time: 16:42
 */
/*
Template Name: 发布qa
*/

$current_url = home_url(add_query_arg(array()));
if( !current_user_can( 'manage_options' ) ) {
    return ;
}
$my_post=0;
if(!$_GET['qa_id'])
{
    return '页面未找到';
}

if($_GET){
    $campus=get_post($_GET['campus_id']);
    $user=get_user_by('ID',$campus->post_author);

    if(isset($_GET['pass'])) {

        update_post_meta($_GET['pass'], 'customer_publish', true);



        header('Location: ' . $_GET['destination']);
    }
    if(isset($_GET['fail'])) {
        update_post_meta($_GET['fail'], 'customer_publish', false);
        header('Location: ' . $_GET['destination']);
        //echo get_user_meta($user->ID,'locale',true);

      // update_post_meta($_GET['fail'], 'status', 'failed');
    }




}


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